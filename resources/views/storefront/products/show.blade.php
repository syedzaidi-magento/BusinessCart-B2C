<x-app-layout>
    <x-slot name="title">{{ $product->name }}</x-slot>
    <x-slot name="pageTitle">{{ $product->name }}</x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <!-- Breadcrumb -->
        <nav class="bg-gray-100 py-3 px-6">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('storefront.products.index') }}" class="hover:text-primary">Products</a></li>
                <li>/</li>
                <li>{{ $product->name }}</li>
            </ol>
        </nav>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="bg-white shadow-md rounded-lg p-6">
                @if ($product->images->isNotEmpty())
                    <!-- Main Image -->
                    <img id="main-image" src="{{ $product->images->where('is_main', true)->first()->url ?? $product->images->first()->url }}"
                         alt="{{ $product->images->where('is_main', true)->first()->alt_text ?? 'Product Image' }}"
                         loading="lazy"
                         class="w-full h-100 object-cover rounded-lg mb-4 transition-transform duration-300 hover:scale-105">

                    <!-- Thumbnail Gallery -->
                    <div class="flex space-x-2">
                        @foreach ($product->images as $image)
                            <img src="{{ $image->url }}"
                                 alt="{{ $image->alt_text }}"
                                 data-main-src="{{ $image->url }}"
                                 loading="lazy"
                                 class="w-16 h-16 object-cover rounded-md cursor-pointer border-2 hover:border-primary transition-all duration-200 {{ $image->is_main ? 'border-primary' : 'border-transparent' }}">
                        @endforeach
                    </div>
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">Type: <span class="font-medium">{{ ucfirst($product->type) }}</span></p>

                <!-- Pricing -->
                <div class="mb-6" id="pricing-section" data-base-price="{{ $product->price }}">
                    @if ($product->getEffectivePrice() < $product->price)
                        <p id="original-price" class="text-gray-500 line-through text-xl">${{ number_format($product->price, 2) }}</p>
                        <p id="effective-price" class="text-red-800 font-bold text-2xl">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                    @else
                        <p id="effective-price" class="text-red-800 font-bold text-2xl">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                    @endif
                    <p id="stock-status" class="text-sm text-gray-500 mt-1">
                        {{ $product->isInStock() ? 'In Stock' : 'Out of Stock' }} 
                        ({{ $product->inventory && $product->inventory->quantity > 0 ? $product->inventory->quantity : 0 }} available)
                    </p>
                    @if (auth()->check())
                        <p class="text-sm text-gray-500 mt-1">Your Price Group: {{ auth()->user()->customerGroup->name ?? 'Customer' }}</p>
                    @endif
                </div>
                <form action="{{ route('wishlist.store') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="text-gray-600 hover:text-[var(--primary-color)]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </form>
                <!-- Add to Cart Form -->
                <form method="POST" action="{{ route('storefront.cart.add', $product) }}" class="mb-6">
                    @csrf
                    @if ($product->type === 'configurable' && $product->variations->isNotEmpty())
                        <!-- Variation Selector -->
                        <div class="mb-4">
                            <label for="variation" class="block text-gray-700 font-medium mb-2">Select Variation</label>
                            <select name="variation_id" id="variation" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                                <option value="">Select an option</option>
                                @foreach ($product->variations as $variation)
                                    <option value="{{ $variation->id }}" 
                                            data-price-adjustment="{{ $variation->price_adjustment ?? 0 }}"
                                            data-quantity="{{ $variation->quantity }}">
                                        {{ $variation->attribute }}: {{ $variation->value }} (+${{ number_format($variation->price_adjustment, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
                        <input type="number" name="quantity" id="quantity" min="1" 
                               value="1" 
                               max="{{ $product->inventory && $product->inventory->quantity > 0 ? $product->inventory->quantity : 1 }}" 
                               class="w-24 p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                               {{ $product->isInStock() ? '' : 'disabled' }}>
                    </div>

                    <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:bg-gray-400 disabled:cursor-not-allowed" 
                            {{ $product->isInStock() ? '' : 'disabled' }}>
                        Add to Cart
                    </button>
                </form>

                <!-- Description -->
                @if ($product->short_description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Short Description</h3>
                        <p class="text-gray-700">{{ $product->short_description }}</p>
                    </div>
                @endif

                <!-- Related Products or Variations -->
                @if ($product->type === 'configurable' && $product->variations->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Variations</h3>
                        <ul class="list-disc pl-5 text-gray-700">
                            @foreach ($product->variations as $variation)
                                <li>{{ $variation->attribute }}: {{ $variation->value }} (+${{ number_format($variation->price_adjustment, 2) }})</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (in_array($product->type, ['grouped', 'bundle']) && $product->relatedProducts->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Related Products</h3>
                        <ul class="list-disc pl-5 text-gray-700">
                            @foreach ($product->relatedProducts as $related)
                                <li><a href="{{ route('storefront.products.show', $related) }}" class="text-primary hover:underline">{{ $related->name }}</a> - ${{ number_format($related->getEffectivePrice(), 2) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Social Sharing -->
                <div class="flex space-x-4">
                    <h3 class="text-lg font-semibold text-gray-800">Share:</h3>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('storefront.products.show', $product)) }}&text={{ urlencode($product->name) }}" target="_blank" class="text-gray-500 hover:text-primary">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.3 4.3 0 001.88-2.38 8.6 8.6 0 01-2.72 1.05 4.3 4.3 0 00-7.32 3.92A12.2 12.2 0 011.67 5.59a4.3 4.3 0 001.33 5.74c-.65-.02-1.27-.2-1.8-.5v.05a4.3 4.3 0 003.44 4.2 4.3 4.3 0 01-1.94.07 4.3 4.3 0 004 2.98A8.6 8.6 0 010 20.56a12.2 12.2 0 006.6 1.94c7.92 0 12.24-6.56 12.24-12.24 0-.19 0-.38-.01-.57A8.7 8.7 0 0022.46 6z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('storefront.products.show', $product)) }}" target="_blank" class="text-gray-500 hover:text-primary">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7v-3h3V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.84-.98 8.44-4.99 8.44-9.95z"/></svg>
                    </a>
                </div>
            </div>
        </div>

<!-- Description and Attributes -->
<div class="bg-white shadow-md rounded-lg p-6 mt-6 border border-gray-200">
    <div class="grid grid-cols-1 gap-6">
        <!-- Description -->
        @if ($product->description)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2">Product Description</h2>
                <div class="text-gray-700 leading-relaxed prose prose-sm max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            <span class="border-b border-gray-300"></span>
        @endif

        <!-- Attributes -->
        @if ($attributeKeys->isNotEmpty())
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2">Additional Information</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <tbody>
                            @foreach ($attributeKeys as $key)
                                @if (isset($product->custom_attributes[$key->key_name]))
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                        <th class="text-left px-4 py-3 text-gray-600 font-medium bg-gray-100 border-r border-gray-200 w-1/3">
                                            {{ ucfirst(str_replace('_', ' ', $key->key_name)) }}
                                        </th>
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ $product->custom_attributes[$key->key_name] }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-300">Additional Information</h2>
                <p class="text-gray-600 italic">No additional information available.</p>
            </div>
        @endif
    </div>
</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing thumbnail gallery logic
            const thumbnails = document.querySelectorAll('.cursor-pointer');
            const mainImage = document.getElementById('main-image');
    
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    mainImage.src = this.getAttribute('data-main-src');
                });
            });

            // Price and stock update logic for configurable products
            const pricingSection = document.getElementById('pricing-section');
            const originalPriceElement = document.getElementById('original-price');
            const effectivePriceElement = document.getElementById('effective-price');
            const stockStatusElement = document.getElementById('stock-status');
            const variationSelect = document.getElementById('variation');
            const quantityInput = document.getElementById('quantity');
            const addToCartButton = document.querySelector('button[type="submit"]');
            const basePrice = parseFloat(pricingSection.dataset.basePrice);

            if (variationSelect) {
                variationSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const priceAdjustment = parseFloat(selectedOption.dataset.priceAdjustment) || 0;
                    const variationQuantity = parseInt(selectedOption.dataset.quantity) || 0;
                    const newPrice = basePrice + priceAdjustment;

                    // Update price
                    effectivePriceElement.textContent = `$${newPrice.toFixed(2)}`;
                    if (priceAdjustment > 0 && originalPriceElement) {
                        originalPriceElement.classList.remove('hidden');
                    } else if (originalPriceElement) {
                        originalPriceElement.classList.add('hidden');
                    }

                    // Update stock status and quantity input
                    if (selectedOption.value === '') {
                        // Reset to product-level stock if no variation selected
                        const productQuantity = {{ $product->inventory && $product->inventory->quantity > 0 ? $product->inventory->quantity : 0 }};
                        stockStatusElement.textContent = `${productQuantity > 0 ? 'In Stock' : 'Out of Stock'} (${productQuantity} available)`;
                        quantityInput.max = productQuantity > 0 ? productQuantity : 1;
                        quantityInput.disabled = productQuantity <= 0;
                        addToCartButton.disabled = productQuantity <= 0;
                    } else {
                        // Update based on selected variation
                        stockStatusElement.textContent = `${variationQuantity > 0 ? 'In Stock' : 'Out of Stock'} (${variationQuantity} available)`;
                        quantityInput.max = variationQuantity > 0 ? variationQuantity : 1;
                        quantityInput.disabled = variationQuantity <= 0;
                        addToCartButton.disabled = variationQuantity <= 0;
                    }
                });

                // Trigger change event on load to set initial state if a variation is pre-selected
                if (variationSelect.value) {
                    variationSelect.dispatchEvent(new Event('change'));
                }
            }
        });
    </script>
</x-app-layout>