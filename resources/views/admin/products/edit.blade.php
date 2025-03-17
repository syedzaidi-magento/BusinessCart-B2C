@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <!-- Display Existing Images -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Current Images</h3>
            @if ($product->images->isNotEmpty())
                <div class="flex space-x-2 flex-wrap">
                    @foreach ($product->images as $image)
                        <div class="mb-2">
                            <img src="{{ $image->url }}"
                                 alt="{{ $image->alt_text }}"
                                 class="w-24 h-24 object-cover border rounded-lg">
                            <p class="text-sm text-gray-600 text-center">{{ $image->alt_text }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No images uploaded yet.</p>
            @endif
        </div>

        <!-- Upload Form -->
        <form action="{{ route('admin.products.uploadImages', $product) }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="flex space-x-2 items-end">
                <div class="flex-1">
                    <label class="block text-gray-700 font-medium mb-2">Upload Images</label>
                    <input type="file" name="images[]" multiple required class="w-full p-2 border rounded-lg">
                </div>
                <div class="flex-1">
                    <label class="block text-gray-700 font-medium mb-2">Alt Text</label>
                    <input type="text" name="alt_text" placeholder="Alt Text" class="w-full p-2 border rounded-lg">
                </div>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">Upload</button>
            </div>
        </form>

        <!-- Update Form -->
        <form method="POST" action="{{ route('admin.products.update', $product) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="store_id" class="block text-gray-700 font-medium mb-2">Store</label>
                    <select name="store_id" id="store_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('store_id') border-red-500 @enderror">
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-gray-700 font-medium mb-2">SKU</label>
                    <input type="text" name="sku" id="sku" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('sku') border-red-500 @enderror" value="{{ old('sku', $product->sku) }}">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                    <select name="type" id="type" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror">
                        <option value="simple" {{ old('type', $product->type) == 'simple' ? 'selected' : '' }}>Simple</option>
                        <option value="configurable" {{ old('type', $product->type) == 'configurable' ? 'selected' : '' }}>Configurable</option>
                        <option value="grouped" {{ old('type', $product->type) == 'grouped' ? 'selected' : '' }}>Grouped</option>
                        <option value="bundle" {{ old('type', $product->type) == 'grouped' ? 'selected' : '' }}>Bundle</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('price') border-red-500 @enderror" value="{{ old('price', $product->price) }}">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="quantity-container" class="{{ old('type', $product->type) === 'simple' ? '' : 'hidden' }}">
                    <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('quantity') border-red-500 @enderror" value="{{ old('quantity', $product->quantity) }}">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="custom-attributes">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Custom Attributes</h3>
                    @foreach ($attributeKeys as $key)
                        <div class="mb-4">
                            <label for="custom_attributes_{{ $key->key_name }}" class="block text-gray-700 font-medium mb-2">
                                {{ ucfirst($key->key_name) }} ({{ $key->data_type }}) {{ $key->is_required ? '*' : '' }}
                            </label>
                            <input type="text" 
                                   name="custom_attributes[{{ $key->key_name }}]" 
                                   id="custom_attributes_{{ $key->key_name }}" 
                                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('custom_attributes.' . $key->key_name) border-red-500 @enderror" 
                                   value="{{ old('custom_attributes.' . $key->key_name, $product->custom_attributes[$key->key_name] ?? '') }}">
                            @error('custom_attributes.' . $key->key_name)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div id="variations-container" class="{{ old('type', $product->type) == 'configurable' ? '' : 'hidden' }}">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Variations</h3>
                    <div id="variations">
                        @forelse (old('variations', $product->variations->toArray()) as $index => $variation)
                            <div class="variation flex space-x-2 mb-2">
                                <input type="text" name="variations[{{ $index }}][attribute]" placeholder="Attribute" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['attribute'] }}">
                                <input type="text" name="variations[{{ $index }}][value]" placeholder="Value" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['value'] }}">
                                <input type="number" step="0.01" name="variations[{{ $index }}][price_adjustment]" placeholder="Price Adjustment" class="p-2 border rounded-lg w-24 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['price_adjustment'] }}">
                                <input type="number" name="variations[{{ $index }}][quantity]" placeholder="Quantity" class="p-2 border rounded-lg w-24 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['quantity'] ?? 0 }}">
                                <button type="submit" name="remove_variation" value="{{ $index }}" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200">Remove</button>
                            </div>
                        @empty
                            <!-- Empty state if no variations -->
                        @endforelse
                        <button type="submit" name="add_variation" value="1" class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-dark transition-colors duration-200 mt-2">Add Variation</button>
                    </div>
                </div>

                <div id="related-products-container" class="{{ in_array(old('type', $product->type), ['grouped', 'bundle']) ? '' : 'hidden' }}">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Related Products</h3>
                    <div id="related-products">
                        @forelse (old('related_products', $product->relatedProducts->pluck('id')->toArray()) as $index => $relatedId)
                            <div class="related-product flex space-x-2 mb-2">
                                <select name="related_products[{{ $index }}]" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                                    @foreach ($simpleProducts as $simple)
                                        <option value="{{ $simple->id }}" {{ $relatedId == $simple->id ? 'selected' : '' }}>{{ $simple->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" name="remove_related" value="{{ $index }}" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200">Remove</button>
                            </div>
                        @empty
                            <!-- Empty state if no related products -->
                        @endforelse
                        <button type="submit" name="add_related" value="1" class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-dark transition-colors duration-200 mt-2">Add Related Product</button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Update Product</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleProductType(type) {
            document.getElementById('quantity-container').classList.toggle('hidden', type !== 'simple');
            document.getElementById('variations-container').classList.toggle('hidden', type !== 'configurable');
            document.getElementById('related-products-container').classList.toggle('hidden', !['grouped', 'bundle'].includes(type));
        }
        document.addEventListener('DOMContentLoaded', function () {
            toggleProductType('{{ old('type', $product->type) }}');
            document.getElementById('type').addEventListener('change', function () {
                toggleProductType(this.value);
            });
        });
    </script>
@endsection