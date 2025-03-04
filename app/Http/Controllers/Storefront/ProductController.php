<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\AttributeKey;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $storeId = config('app.enable_multi_store') ? App::get('current_store')->id ?? null : null;
        if (auth()->check() && auth()->user()->store_id) {
            $storeId = auth()->user()->store_id;
        }

        $categoryId = $request->query('category_id');
        $cacheKey = 'products_list_' . $storeId . '_' . $categoryId . '_' . $request->get('page', 1);
        $products = Cache::remember($cacheKey, 60, function () use ($storeId, $categoryId) {
            $query = Product::when($storeId, fn($query) => $query->where('store_id', $storeId))
                ->with(['variations', 'relatedProducts', 'catalogPriceRules', 'tieredPricing']);
            if ($categoryId) {
                $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
            }
            return $query->paginate(12);
        });

        $categories = Category::all();
        return view('storefront.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $storeId = config('app.enable_multi_store') ? App::get('current_store')->id ?? null : null;
        if (auth()->check() && auth()->user()->store_id) {
            $storeId = auth()->user()->store_id;
        }
    
        if ($storeId && $product->store_id !== $storeId) {
            abort(404);
        }
    
        $product->load(['variations', 'relatedProducts', 'catalogPriceRules', 'tieredPricing', 'inventory', 'images']);
        $attributeKeys = AttributeKey::where('model_type', 'Product')->get();
        
        \Log::debug('Product Images: ' . $product->images->toJson());
        \Log::debug("Product {$product->id} inventory: " . json_encode($product->inventory));
        \Log::debug("Product {$product->id} isInStock: " . ($product->isInStock() ? 'true' : 'false'));
        return view('storefront.products.show', compact('product', 'attributeKeys'));
    }
}