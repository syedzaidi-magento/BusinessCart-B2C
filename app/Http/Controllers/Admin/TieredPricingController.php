<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TieredPricing;
use Illuminate\Http\Request;

class TieredPricingController extends Controller
{
    public function index()
    {
        $tiers = TieredPricing::with('product')->paginate(10);
        return view('admin.tiered_pricing.index', compact('tiers'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.tiered_pricing.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // Specify connection
            'min_quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        TieredPricing::create($request->all());
        return redirect()->route('admin.tiered-pricing.index')->with('success', 'Tiered pricing created.');
    }

    public function edit(TieredPricing $tieredPricing)
    {
        $products = Product::all();
        return view('admin.tiered_pricing.edit', compact('tieredPricing', 'products'));
    }

    public function update(Request $request, TieredPricing $tieredPricing)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // Specify connection
            'min_quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $tieredPricing->update($request->all());
        return redirect()->route('admin.tiered-pricing.index')->with('success', 'Tiered pricing updated.');
    }
}