<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('storefront.products.index')->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = $products->sum(function ($product) use ($cart) {
            return $product->price * $cart[$product->id];
        });

        if ($request->isMethod('post')) {
            $request->validate([
                'warehouse_id' => 'required|exists:warehouses,id', // Customer selects warehouse
                'shelf_id' => 'required|exists:shelves,id', // Customer selects shelf
            ]);

            $storeId = config('app.enable_multi_store') ? App::get('current_store')->id ?? null : null;
            if (auth()->check() && auth()->user()->store_id) {
                $storeId = auth()->user()->store_id;
            }

            // Check stock availability
            foreach ($products as $product) {
                $requiredQty = $cart[$product->id];
                $inventory = Inventory::where('product_id', $product->id)
                    ->where('warehouse_id', $request->input('warehouse_id'))
                    ->where('shelf_id', $request->input('shelf_id'))
                    ->first();
                $availableQty = $inventory ? $inventory->quantity : 0;
                if ($requiredQty > $availableQty) {
                    return redirect()->route('storefront.cart.index')->with('error', "Insufficient stock for {$product->name} at selected location. Available: $availableQty, Requested: $requiredQty.");
                }
            }

            $order = Order::create([
                'store_id' => $storeId,
                'customer_id' => auth()->id(),
                'status' => 'pending',
                'total' => $total,
                'custom_attributes' => [
                    'shipping_address' => auth()->user()->shippingAddress->toArray(),
                    'billing_address' => auth()->user()->billingAddress->toArray(),
                    'warehouse_id' => $request->input('warehouse_id'),
                    'shelf_id' => $request->input('shelf_id'),
                ],
                'placed_at' => now(),
            ]);

            // Update inventory
            foreach ($products as $product) {
                $inventory = Inventory::where('product_id', $product->id)
                    ->where('warehouse_id', $request->input('warehouse_id'))
                    ->where('shelf_id', $request->input('shelf_id'))
                    ->first();
                if ($inventory) {
                    $inventory->quantity -= $cart[$product->id];
                    $inventory->save();
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
            return redirect()->route('storefront.products.index')->with('success', 'Order placed successfully! Order ID: ' . $order->id);
        }

        $warehouses = Warehouse::with('shelves')->get();
        return view('storefront.checkout.index', compact('cart', 'products', 'total', 'warehouses'));
    }
}