<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogPriceRule;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogPriceRuleController extends Controller
{
    public function index()
    {
        $rules = CatalogPriceRule::all();
        return view('admin.catalog_price_rules.index', compact('rules'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.catalog_price_rules.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $rule = CatalogPriceRule::create($request->only(['name', 'discount_percentage', 'discount_amount', 'start_date', 'end_date', 'is_active']));
        if ($request->has('products')) {
            $rule->products()->sync($request->input('products'));
        }

        return redirect()->route('admin.catalog-price-rules.index')->with('success', 'Catalog price rule created.');
    }

    public function edit(CatalogPriceRule $catalogPriceRule)
    {
        $products = Product::all();
        $catalogPriceRule->load('products');
        return view('admin.catalog_price_rules.edit', compact('catalogPriceRule', 'products'));
    }

    public function update(Request $request, CatalogPriceRule $catalogPriceRule)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $catalogPriceRule->update($request->only(['name', 'discount_percentage', 'discount_amount', 'start_date', 'end_date', 'is_active']));
        $catalogPriceRule->products()->sync($request->input('products', []));

        return redirect()->route('admin.catalog-price-rules.index')->with('success', 'Catalog price rule updated.');
    }
}