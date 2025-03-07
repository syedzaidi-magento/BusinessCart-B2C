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
        // Determine the store ID based on multi-store config or authenticated user
        $storeId = config('app.enable_multi_store') ? App::get('current_store')->id ?? null : null;
        if (auth()->check() && auth()->user()->store_id) {
            $storeId = auth()->user()->store_id;
        }

        // Retrieve query parameters
        $categoryId = $request->query('category_id');
        $search = $request->query('search');
        $sort = $request->query('sort', 'name_asc'); // Default to sorting by name ascending

        // Create a unique cache key incorporating all parameters
        $cacheKey = 'products_list_' . $storeId . '_' . $categoryId . '_' . $search . '_' . $sort . '_' . $request->get('page', 1);

        // Fetch products with caching
        $products = Cache::remember($cacheKey, 60, function () use ($storeId, $categoryId, $search, $sort) {
            $query = Product::when($storeId, fn($query) => $query->where('store_id', $storeId))
                ->with(['variations', 'relatedProducts', 'catalogPriceRules', 'tieredPricing', 'images']);

            // Apply category filter
            if ($categoryId) {
                $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
            }

            // Apply search filter
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Apply sorting
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc'); // Fallback to default
            }

            return $query->paginate(12);
        });

        // Fetch all categories for the view
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