<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\Payments\AmazonPayService;
use App\Services\Payments\GooglePayService;
use App\Services\Payments\StripePayService;
use App\Services\Payments\PurchaseOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to complete your checkout.');
        }

        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('storefront.products.index')->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $subtotal = $products->sum(function ($product) use ($cart) {
            return $product->price * $cart[$product->id];
        });

        $storeId = config('app.enable_multi_store') ? App::get('current_store')->id ?? null : null;
        if (auth()->user()->store_id) {
            $storeId = auth()->user()->store_id;
        }

        $taxRate = Configuration::getConfigValue('tax_rate', $storeId);
        $freeShippingEnabled = Configuration::getConfigValue('shipping_method_free_enable', $storeId);
        $freeShippingMin = Configuration::getConfigValue('shipping_method_free_minimum', $storeId);
        $flatRateEnabled = Configuration::getConfigValue('shipping_method_flat_rate_enable', $storeId);
        $flatRateAmount = Configuration::getConfigValue('shipping_method_flat_rate_amount', $storeId);

        $paymentMethods = [];
        $paymentMethodLabels = [];
        $paymentConfigs = [];

        if (Configuration::getConfigValue('payment_method_amazon_enable', $storeId)) {
            $paymentMethods[] = 'amazon_pay';
            $paymentMethodLabels['amazon_pay'] = Configuration::getConfigValue('payment_method_amazon_label', $storeId) ?? 'Amazon Pay';
            $paymentConfigs['amazon_pay'] = [
                'client_id' => Configuration::getConfigValue('payment_method_amazon_access_key', $storeId),
                'merchant_id' => Configuration::getConfigValue('payment_method_amazon_merchant_id', $storeId),
            ];
        }

        if (Configuration::getConfigValue('payment_method_google_enable', $storeId)) {
            $paymentMethods[] = 'google_pay';
            $paymentMethodLabels['google_pay'] = Configuration::getConfigValue('payment_method_google_label', $storeId) ?? 'Google Pay';
            $paymentConfigs['google_pay'] = [];
        }

        if (Configuration::getConfigValue('payment_method_stripe_enable', $storeId)) {
            $paymentMethods[] = 'stripe';
            $paymentMethodLabels['stripe'] = Configuration::getConfigValue('payment_method_stripe_label', $storeId) ?? 'Stripe';
            $paymentConfigs['stripe'] = [
                'publishable_key' => Configuration::getConfigValue('payment_method_stripe_publishable_key', $storeId),
            ];
        }

        if (Configuration::getConfigValue('payment_method_po_enable', $storeId)) {
            $paymentMethods[] = 'purchase_order';
            $paymentMethodLabels['purchase_order'] = Configuration::getConfigValue('payment_method_po_label', $storeId) ?? 'Purchase Order';
            $paymentConfigs['purchase_order'] = [];
        }

        $warehouses = Warehouse::with('shelves')->get();

        if ($request->isMethod('post')) {
            $request->validate([
                'shipping_method' => 'required|in:pickup,delivery',
                'warehouse_id' => 'required_if:shipping_method,pickup|exists:warehouses,id',
                'shelf_id' => 'required_if:shipping_method,pickup|exists:shelves,id',
                'shipping_address_id' => 'required_if:shipping_method,delivery|exists:user_addresses,id',
                'billing_address_id' => 'required|exists:user_addresses,id',
                'payment_method' => 'required|in:' . implode(',', $paymentMethods),
                'payment_token' => 'required_if:payment_method,google_pay',
                'payment_method_id' => 'required_if:payment_method,stripe',
                'order_reference_id' => 'required_if:payment_method,amazon_pay',
                'po_number' => 'required_if:payment_method,purchase_order|string|max:255',
            ]);

            // Inventory check
            if ($request->shipping_method === 'pickup') {
                foreach ($products as $product) {
                    $requiredQty = $cart[$product->id];
                    $inventory = Inventory::where('product_id', $product->id)
                        ->where('warehouse_id', $request->warehouse_id)
                        ->where('shelf_id', $request->shelf_id)
                        ->first();
                    $availableQty = $inventory ? $inventory->quantity : 0;
                    if ($requiredQty > $availableQty) {
                        return redirect()->route('storefront.cart.index')
                            ->with('error', "Insufficient stock for {$product->name} at selected location.");
                    }
                }
            } else {
                foreach ($products as $product) {
                    $requiredQty = $cart[$product->id];
                    $totalStock = Inventory::where('product_id', $product->id)->sum('quantity');
                    if ($requiredQty > $totalStock) {
                        return redirect()->route('storefront.cart.index')
                            ->with('error', "Insufficient stock for {$product->name}.");
                    }
                }
            }

            // Calculate costs
            $tax = $subtotal * $taxRate;
            $shippingCost = 0;
            if ($request->shipping_method === 'delivery') {
                if ($flatRateEnabled) {
                    $shippingCost = $flatRateAmount;
                } elseif ($freeShippingEnabled) {
                    $shippingCost = $subtotal >= $freeShippingMin ? 0 : 5.99;
                }
            }
            $total = $subtotal + $tax + $shippingCost;

            // Prepare order data
            $customAttributes = [
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'subtotal' => $subtotal,
            ];

            $billingAddress = auth()->user()->addresses()->find($request->billing_address_id);
            $customAttributes['billing_address'] = $billingAddress->toArray();

            if ($request->shipping_method === 'pickup') {
                $customAttributes['warehouse_id'] = $request->warehouse_id;
                $customAttributes['shelf_id'] = $request->shelf_id;
            } else {
                $shippingAddress = auth()->user()->addresses()->find($request->shipping_address_id);
                $customAttributes['shipping_address'] = $shippingAddress->toArray();
            }

            // Process payment
            try {
                $paymentService = $this->getPaymentService($request->payment_method);
                $paymentOptions = [
                    'order_id' => 'ORDER-' . time(),
                ];

                if ($request->payment_method === 'amazon_pay') {
                    $paymentOptions['order_reference_id'] = $request->order_reference_id;
                } elseif ($request->payment_method === 'google_pay') {
                    $paymentOptions['payment_token'] = $request->payment_token;
                } elseif ($request->payment_method === 'stripe') {
                    $paymentOptions['payment_method_id'] = $request->payment_method_id;
                } elseif ($request->payment_method === 'purchase_order') {
                    $paymentOptions['po_number'] = $request->po_number;
                }

                $paymentResult = $paymentService->processPayment($total, 'USD', $paymentOptions);
                $customAttributes['transaction_id'] = $paymentResult['transaction_id'];
                if ($request->payment_method === 'purchase_order') {
                    $customAttributes['po_number'] = $paymentResult['po_number'];
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
            }

            // Create order
            $order = Order::create([
                'store_id' => $storeId,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total' => $total,
                'custom_attributes' => $customAttributes,
                'placed_at' => now(),
            ]);

            // Update inventory for pickup
            if ($request->shipping_method === 'pickup') {
                foreach ($products as $product) {
                    $inventory = Inventory::where('product_id', $product->id)
                        ->where('warehouse_id', $request->warehouse_id)
                        ->where('shelf_id', $request->shelf_id)
                        ->first();
                    if ($inventory) {
                        $inventory->quantity -= $cart[$product->id];
                        $inventory->save();
                    }
                }
            }

            $order->update([
                'custom_attributes' => array_merge($order->custom_attributes, [
                    'cart_items' => collect($products)->mapWithKeys(function ($product) use ($cart) {
                        return [$product->id => ['quantity' => $cart[$product->id], 'price' => $product->price]];
                    })->all(),
                ]),
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $request->session()->forget('cart');

            // Redirect to success page with order ID
            return redirect()->route('storefront.order.success', ['order' => $order->id]);
        }

        return view('storefront.checkout.index', compact(
            'cart',
            'products',
            'subtotal',
            'warehouses',
            'taxRate',
            'freeShippingEnabled',
            'freeShippingMin',
            'flatRateEnabled',
            'flatRateAmount',
            'paymentMethods',
            'paymentMethodLabels',
            'paymentConfigs'
        ));
    }

    // New method for success page
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to view this order.');
        }

        return view('storefront.checkout.success', compact('order'));
    }

    private function getPaymentService($method)
    {
        switch ($method) {
            case 'amazon_pay':
                return new AmazonPayService();
            case 'google_pay':
                return new GooglePayService();
            case 'stripe':
                return new StripePayService();
            case 'purchase_order':
                return new PurchaseOrderService();
            default:
                throw new \Exception('Unsupported payment method: ' . $method);
        }
    }
}