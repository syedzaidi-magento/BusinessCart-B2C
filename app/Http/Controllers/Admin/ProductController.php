<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Store;
use App\Models\AttributeKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('variations', 'store', 'relatedProducts', 'images');
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $query->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $attributeKeys = AttributeKey::where('model_type', 'Product')->get();
        $stores = Store::all();
        $simpleProducts = Product::where('type', 'simple')->get(); // For Grouped/Bundle selection
        return view('admin.products.create', compact('stores', 'simpleProducts', 'attributeKeys'));
    }

    public function store(Request $request)
    {
        $attributeKeys = AttributeKey::where('model_type', 'Product')->get();
    
        // Validation rules
        $rules = $attributeKeys->mapWithKeys(function ($key) {
            $rule = $key->data_type === 'integer' ? 'integer' : ($key->data_type === 'boolean' ? 'boolean' : 'string');
            if ($key->is_required) {
                $rule = "required|$rule";
            }
            return ["custom_attributes.{$key->key_name}" => $rule];
        })->all();
    
        Log::debug('Store Request Data: ' . json_encode($request->all()));
    
        try {
            $request->validate(array_merge([
                'custom_attributes' => 'nullable|array',
                'custom_attributes.*' => 'string',
                'store_id' => 'required|exists:stores,id',
                'name' => 'required|string|max:255',
                'type' => 'required|in:' . implode(',', Product::TYPES),
                'price' => 'required|numeric|min:0',
                'quantity' => 'nullable|required_if:type,simple|integer|min:0', // Updated rule
                'description' => 'nullable|string',
                'short_description' => 'nullable|string',
                'featured' => 'nullable|boolean',
                'variations' => 'nullable|array',
                'variations.*.attribute' => 'required_with:variations|string',
                'variations.*.value' => 'required_with:variations|string',
                'variations.*.price_adjustment' => 'nullable|numeric',
                'variations.*.quantity' => 'required_with:variations|integer|min:0',
                'related_products' => 'required_if:type,grouped,bundle|array',
                'related_products.*' => 'exists:products,id',
            ], $rules));
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->validator)->withInput(); // Ensure UI shows errors
        }
    
        // Filter only populated attributes
        $customAttributes = collect($request->input('custom_attributes', []))
            ->filter(fn ($value, $key) => !empty($value) && in_array($key, $attributeKeys->pluck('key_name')->toArray()))
            ->all();
    
        Log::debug('Custom Attributes to Save: ' . json_encode($customAttributes));
    
        // Create the product
        $product = Product::create(array_merge(
            $request->only([
                'store_id', 
                'name',
                'sku', 
                'type', 
                'price', 
                'quantity', 
                'description',
                'short_description',
                'featured',
            ]),
            ['custom_attributes' => $customAttributes]
        ));
    
        Log::debug('Product Created: ' . $product->id);
    
        // Handle configurable product variations
        if ($request->type === 'configurable' && $request->has('variations')) {
            Log::debug('Processing Configurable Product Variations: ' . json_encode($request->variations));
            foreach ($request->variations as $index => $variationData) {
                try {
                    $variation = $product->variations()->create($variationData);
                    Log::debug('Variation Created: ' . $variation->id . ' for Product: ' . $product->id);
                } catch (\Exception $e) {
                    Log::error('Failed to create variation at index ' . $index . ': ' . $e->getMessage());
                }
            }
        } elseif (in_array($request->type, ['grouped', 'bundle']) && $request->has('related_products')) {
            Log::debug('Processing Related Products: ' . json_encode($request->related_products));
            foreach ($request->related_products as $index => $relatedId) {
                $product->relatedProducts()->attach($relatedId, ['position' => $index]);
            }
        }
    
        Log::debug('Product Creation Completed for ID: ' . $product->id);
    
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $stores = Store::all();
        $simpleProducts = Product::where('type', 'simple')->get();
        $attributeKeys = AttributeKey::where('model_type', 'Product')->get();
        $product->load('variations', 'relatedProducts', 'images'); // Add images
        Log::debug('Edit Product Images: ' . $product->images->toJson());
        return view('admin.products.edit', compact('product', 'stores', 'simpleProducts', 'attributeKeys'));
    }

    public function update(Request $request, Product $product)
    {
        $attributeKeys = AttributeKey::where('model_type', 'Product')->get();
    
        // Dynamic validation rules based on attribute keys
        $rules = $attributeKeys->mapWithKeys(function ($key) {
            $rule = $key->data_type === 'integer' ? 'integer' : ($key->data_type === 'boolean' ? 'boolean' : 'string');
            return ["custom_attributes.{$key->key_name}" => ($key->is_required ? "required|$rule" : "nullable|$rule")];
        })->all();
    
        Log::debug('Update Request Data: ' . json_encode($request->all()));
    
        try {
            $request->validate(array_merge([
                'store_id' => 'required|exists:stores,id',
                'name' => 'required|string|max:255',
                'type' => 'required|in:' . implode(',', Product::TYPES),
                'price' => 'required|numeric|min:0',
                'quantity' => 'nullable|required_if:type,simple|integer|min:0', // Adjusted for nullable
                'description' => 'nullable|string',
                'short_description' => 'nullable|string',
                'featured' => 'nullable|boolean',
                'variations' => 'nullable|array',
                'variations.*.attribute' => 'required_with:variations|string',
                'variations.*.value' => 'required_with:variations|string',
                'variations.*.price_adjustment' => 'nullable|numeric',
                'variations.*.quantity' => 'required_with:variations|integer|min:0',
                'related_products' => 'required_if:type,grouped,bundle|array',
                'related_products.*' => 'exists:products,id',
                'custom_attributes' => 'nullable|array',
            ], $rules));
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    
        // Filter only populated attributes
        $customAttributes = collect($request->input('custom_attributes', []))
            ->filter(fn ($value, $key) => !empty($value) && in_array($key, $attributeKeys->pluck('key_name')->toArray()))
            ->all();
    
        Log::debug('Custom Attributes to Update: ' . json_encode($customAttributes));
    
        // Update the product
        $product->update(array_merge(
            $request->only(['store_id', 'name', 'type', 'price', 'quantity', 'description', 'short_description', 'featured']),
            ['custom_attributes' => $customAttributes]
        ));
    
        Log::debug('Product Updated: ' . $product->id);
    
        // Handle configurable product variations
        if ($request->type === 'configurable' && $request->has('variations')) {
            Log::debug('Processing Configurable Product Variations: ' . json_encode($request->variations));
            $product->variations()->delete(); // Delete existing variations
            foreach ($request->variations as $index => $variationData) {
                try {
                    $variation = $product->variations()->create($variationData);
                    Log::debug('Variation Created: ' . $variation->id . ' for Product: ' . $product->id);
                } catch (\Exception $e) {
                    Log::error('Failed to create variation at index ' . $index . ': ' . $e->getMessage());
                }
            }
        } elseif (in_array($request->type, ['grouped', 'bundle']) && $request->has('related_products')) {
            Log::debug('Processing Related Products: ' . json_encode($request->related_products));
            $product->relatedProducts()->detach();
            foreach ($request->related_products as $index => $relatedId) {
                $product->relatedProducts()->attach($relatedId, ['position' => $index]);
            }
        } else {
            $product->variations()->delete();
            $product->relatedProducts()->detach();
        }
    
        Log::debug('Product Update Completed for ID: ' . $product->id);
    
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        Product::whereIn('id', $request->ids)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Selected products deleted successfully.');
    }

    public function uploadImages(Request $request, Product $product)
    {
        Log::debug('UploadImages called for product ID: ' . $product->id);
        Log::debug('Request files: ' . json_encode($request->allFiles()));
        Log::debug('Has images: ' . ($request->hasFile('images') ? 'Yes' : 'No'));
        Log::debug('Full request data: ' . json_encode($request->all()));
        Log::debug('Raw PHP $_FILES: ' . json_encode($_FILES));

        if (!$request->hasFile('images') || empty($request->file('images')) || !array_filter($request->file('images'), fn($file) => $file->isValid())) {
            Log::error('No valid images uploaded in request');
            return back()->withErrors(['images' => 'No valid images were uploaded.']);
        }

        try {
            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'alt_text' => 'nullable|string|max:255',
            ]);
            Log::debug('Validation passed');
        } catch (\Exception $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            throw $e;
        }

        $storageDriver = trim(Configuration::where('group', 'storage')->where('key', 'driver')->first()->value ?? 'local', '"');
        $disk = $storageDriver === 's3' ? 's3' : 'public';

        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $image) {
            if (!$image->isValid()) {
                Log::error('Invalid file detected: ' . $image->getClientOriginalName());
                continue;
            }

            $optimizedImage = $manager->read($image)
                ->scale(width: 800)
                ->toJpeg(75); // Correct 3.x method

            $path = 'images/products/' . uniqid() . '.jpg';
            $result = Storage::disk($disk)->put($path, $optimizedImage);
            Log::debug('Storage put result: ' . ($result ? 'Success' : 'Failed'));

            $imageRecord = $product->images()->create([
                'image_path' => $path,
                'disk' => $storageDriver,
                'position' => $product->images()->count() + 1,
                'is_main' => $product->images()->count() === 0,
                'alt_text' => $request->input('alt_text', 'Product Image'),
            ]);
            Log::debug('Image record created: ' . $imageRecord->id);
        }

        return back()->with('success', 'Images uploaded successfully.');
    }  
}