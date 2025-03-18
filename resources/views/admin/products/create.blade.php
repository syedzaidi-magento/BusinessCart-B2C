@extends('layouts.admin')

@section('title', 'Create Product')
@section('page-title', 'Create Product')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="store_id" class="block text-gray-700 font-medium mb-2">Store</label>
                    <select name="store_id" id="store_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('store_id') border-red-500 @enderror">
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-gray-700 font-medium mb-2">SKU</label>
                    <input type="text" name="sku" id="sku" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('sku') border-red-500 @enderror" value="{{ old('sku') }}">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                    <select name="type" id="type" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror">
                        <option value="simple" {{ old('type', 'simple') == 'simple' ? 'selected' : '' }}>Simple</option>
                        <option value="configurable" {{ old('type') == 'configurable' ? 'selected' : '' }}>Configurable</option>
                        <option value="grouped" {{ old('type') == 'grouped' ? 'selected' : '' }}>Grouped</option>
                        <option value="bundle" {{ old('type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('price') border-red-500 @enderror" value="{{ old('price') }}">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="quantity-container" class="{{ old('type', 'simple') !== 'simple' ? 'hidden' : '' }}">
                    <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('quantity') border-red-500 @enderror" value="{{ old('quantity') }}">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="featured" class="block text-gray-700 font-medium mb-2">Featured</label>
                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary">
                    @error('featured')
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
                                   value="{{ old('custom_attributes.' . $key->key_name) }}">
                            @error('custom_attributes.' . $key->key_name)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div id="variations-container" class="{{ old('type', 'simple') == 'configurable' ? '' : 'hidden' }}">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Variations</h3>
                    <div id="variations">
                        @forelse (old('variations', []) as $index => $variation)
                            <div class="variation flex space-x-2 mb-2">
                                <input type="text" name="variations[{{ $index }}][attribute]" placeholder="Attribute" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['attribute'] ?? '' }}">
                                <input type="text" name="variations[{{ $index }}][value]" placeholder="Value" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['value'] ?? '' }}">
                                <input type="number" step="0.01" name="variations[{{ $index }}][price_adjustment]" placeholder="Price Adjustment" class="p-2 border rounded-lg w-24 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['price_adjustment'] ?? '' }}">
                                <input type="number" name="variations[{{ $index }}][quantity]" placeholder="Quantity" class="p-2 border rounded-lg w-24 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ $variation['quantity'] ?? 0 }}">
                                <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200">Remove</button>
                            </div>
                        @empty
                            <!-- Empty state if no variations -->
                        @endforelse
                        <button type="button" onclick="addVariation()" class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-dark transition-colors duration-200 mt-2">Add Variation</button>
                    </div>
                </div>

                <div id="related-products-container" class="{{ in_array(old('type', 'simple'), ['grouped', 'bundle']) ? '' : 'hidden' }}">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Related Products</h3>
                    <div id="related-products">
                        @forelse (old('related_products', []) as $index => $relatedId)
                            <div class="related-product flex space-x-2 mb-2">
                                <select name="related_products[{{ $index }}]" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                                    @foreach ($simpleProducts as $simple)
                                        <option value="{{ $simple->id }}" {{ $relatedId == $simple->id ? 'selected' : '' }}>{{ $simple->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200">Remove</button>
                            </div>
                        @empty
                            <!-- Empty state if no related products -->
                        @endforelse
                        <button type="button" onclick="addRelatedProduct()" class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-dark transition-colors duration-200 mt-2">Add Related Product</button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save Product</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let variationIndex = {{ old('variations') ? count(old('variations')) : 0 }};
        let relatedIndex = {{ old('related_products') ? count(old('related_products')) : 0 }};

        function toggleProductType(type) {
            document.getElementById('quantity-container').classList.toggle('hidden', type !== 'simple');
            document.getElementById('variations-container').classList.toggle('hidden', type !== 'configurable');
            document.getElementById('related-products-container').classList.toggle('hidden', !['grouped', 'bundle'].includes(type));
        }

        function addVariation() {
            const container = document.getElementById('variations');
            const variationDiv = document.createElement('div');
            variationDiv.className = 'variation flex space-x-2 mb-2';
            variationDiv.innerHTML = `
                <input type="text" name="variations[${variationIndex}][attribute]" placeholder="Attribute" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                <input type="text" name="variations[${variationIndex}][value]" placeholder="Value" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                <input type="number" step="0.01" name="variations[${variationIndex}][price_adjustment]" placeholder="Price Adjustment" class="p-2 border rounded-lg w-24 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                <input type="number" name="variations[${variationIndex}][quantity]" placeholder="Quantity" class="p-2 border rounded-lg w-24 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="0">
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200">Remove</button>
            `;
            container.appendChild(variationDiv);
            variationIndex++;
        }

        function addRelatedProduct() {
            const container = document.getElementById('related-products');
            const relatedDiv = document.createElement('div');
            relatedDiv.className = 'related-product flex space-x-2 mb-2';
            relatedDiv.innerHTML = `
                <select name="related_products[${relatedIndex}]" class="p-2 border rounded-lg flex-1 focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                    @foreach ($simpleProducts as $simple)
                        <option value="{{ $simple->id }}">{{ $simple->name }}</option>
                    @endforeach
                </select>
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200">Remove</button>
            `;
            container.appendChild(relatedDiv);
            relatedIndex++;
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleProductType('{{ old('type', 'simple') }}');
            document.getElementById('type').addEventListener('change', function () {
                toggleProductType(this.value);
            });
        });
    </script>
@endsection