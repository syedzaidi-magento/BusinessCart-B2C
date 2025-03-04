<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CartPriceRule;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))
            ->with(['catalogPriceRules', 'tieredPricing'])
            ->get();
        $cartTotal = $products->sum(fn($product) => $product->getEffectivePrice($cart[$product->id]) * $cart[$product->id]);

        $couponCode = $request->input('coupon_code');
        $discount = 0;

        if ($couponCode) {
            $rule = CartPriceRule::where('coupon_code', $couponCode)->first();
            if ($rule) {
                $result = $rule->applyToCart($cartTotal, $cart);
                $cartTotal = $result['total'];
                $discount = $result['discount'];
                $request->session()->put('applied_coupon', $couponCode);
                return redirect()->route('storefront.cart.index')->with('success', 'Coupon applied successfully!');
            } else {
                $request->session()->forget('applied_coupon');
                return redirect()->route('storefront.cart.index')->with('error', 'Invalid coupon code.');
            }
        } elseif ($request->session()->has('applied_coupon')) {
            $rule = CartPriceRule::where('coupon_code', $request->session()->get('applied_coupon'))->first();
            if ($rule) {
                $result = $rule->applyToCart($cartTotal, $cart);
                $cartTotal = $result['total'];
                $discount = $result['discount'];
            }
        }

        return view('storefront.cart.index', compact('cart', 'products', 'cartTotal', 'discount'));
    }

    public function add(Request $request, Product $product)
    {
        $storeId = config('app.enable_multi_store') ? App::get('current_store')->id ?? null : null;
        if (auth()->check() && auth()->user()->store_id) {
            $storeId = auth()->user()->store_id;
        }

        if ($storeId && $product->store_id !== $storeId) {
            return redirect()->route('storefront.products.index')->with('error', 'Product not available in this store.');
        }

        $cart = $request->session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('storefront.cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $productId => $quantity) {
            if ($quantity > 0) {
                $cart[$productId] = (int) $quantity;
            } else {
                unset($cart[$productId]);
            }
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('storefront.cart.index')->with('success', 'Cart updated.');
    }
}