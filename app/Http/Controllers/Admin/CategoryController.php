<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.categories.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'products' => 'nullable|array',
            'products.*' => 'exists:sqlite_products.products,id',
        ]);

        $category = Category::create($request->only(['name', 'description']));
        if ($request->has('products')) {
            $category->products()->sync($request->input('products'));
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $products = Product::all();
        $category->load('products');
        return view('admin.categories.edit', compact('category', 'products'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'products' => 'nullable|array',
            'products.*' => 'exists:sqlite_products.products,id',
        ]);

        $category->update($request->only(['name', 'description']));
        $category->products()->sync($request->input('products', []));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
}
