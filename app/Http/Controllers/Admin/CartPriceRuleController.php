<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartPriceRule;
use Illuminate\Http\Request;

class CartPriceRuleController extends Controller
{
    public function index()
    {
        $rules = CartPriceRule::all();
        return view('admin.cart_price_rules.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.cart_price_rules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coupon_code' => 'nullable|string|max:255|unique:sqlite_products.cart_price_rules,coupon_code', // Specify connection
            'type' => 'required|in:percentage,fixed,buy_x_get_y_free',
            'discount_value' => 'required_if:type,percentage,fixed|nullable|numeric|min:0',
            'buy_quantity' => 'required_if:type,buy_x_get_y_free|nullable|integer|min:1',
            'free_quantity' => 'required_if:type,buy_x_get_y_free|nullable|integer|min:1',
            'min_cart_total' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        CartPriceRule::create($request->all());
        return redirect()->route('admin.cart-price-rules.index')->with('success', 'Cart price rule created.');
    }

    public function edit(CartPriceRule $cartPriceRule)
    {
        return view('admin.cart_price_rules.edit', compact('cartPriceRule'));
    }

    public function update(Request $request, CartPriceRule $cartPriceRule)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coupon_code' => 'nullable|string|max:255|unique:sqlite_products.cart_price_rules,coupon_code,' . $cartPriceRule->id, // Specify connection
            'type' => 'required|in:percentage,fixed,buy_x_get_y_free',
            'discount_value' => 'required_if:type,percentage,fixed|nullable|numeric|min:0',
            'buy_quantity' => 'required_if:type,buy_x_get_y_free|nullable|integer|min:1',
            'free_quantity' => 'required_if:type,buy_x_get_y_free|nullable|integer|min:1',
            'min_cart_total' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $cartPriceRule->update($request->all());
        return redirect()->route('admin.cart-price-rules.index')->with('success', 'Cart price rule updated.');
    }
}