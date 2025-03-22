<x-app-layout>
    <x-slot name="title">Products</x-slot>
    <x-slot name="pageTitle">Shop Our Products</x-slot>

    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold text-gray-900">Shop Our Products</h2>
                <p class="text-lg text-gray-600 mt-2">Discover the best deals and latest arrivals</p>
            </div>

            <!-- Filters and Search -->
            <div class="flex flex-wrap items-center justify-between mb-8 gap-6">
                <!-- Category Filter -->
                <div class="min-w-0 flex-1">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Filter by Category</label>
                    <form method="GET" action="{{ route('storefront.products.index') }}" class="flex items-center">
                        <select name="category_id" id="category_id" class="w-full max-w-xs p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Sort Options -->
                <div class="min-w-0 flex-1">
                    <label for="sort" class="block text-sm font-semibold text-gray-700 mb-1">Sort By</label>
                    <form method="GET" action="{{ route('storefront.products.index') }}" class="flex items-center">
                        <select name="sort" id="sort" class="w-full max-w-xs p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" onchange="this.form.submit()">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                        </select>
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    </form>
                </div>

                <!-- Search Bar -->
                <div class="min-w-0 flex-1 mt-4">
                    <form method="GET" action="{{ route('storefront.products.index') }}" class="flex items-center">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                               class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                        <button type="submit" class="ml-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Search</button>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 relative">
                        <!-- Product Image -->
                        @if ($product->images->isNotEmpty())
                            <a href="{{ route('storefront.products.show', $product) }}">
                                <img src="{{ $product->images->where('is_main', true)->first()->url ?? $product->images->first()->url }}"
                                     alt="{{ $product->images->where('is_main', true)->first()->alt_text ?? 'Product Image' }}"
                                     loading="lazy"
                                     class="w-full h-64 object-cover transition-transform duration-300 hover:scale-105">
                            </a>
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif

                        <!-- Product Details -->
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 line-clamp-2">{{ $product->name }}</h2>
                            <!-- Stock Badge -->
                            @if ($product->isInStock())
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">In Stock</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Out of Stock</span>
                            @endif
                            <div class="mt-2">
                                @if ($product->getEffectivePrice() < $product->price)
                                    <p class="text-sm flex items-center gap-2">
                                        <span class="line-through text-gray-400 decoration-gray-400">${{ number_format($product->price, 2) }}</span>
                                        <span class="text-teal-600 font-bold text-lg">${{ number_format($product->getEffectivePrice(), 2) }}</span>
                                    </p>
                                @else
                                    <p class="text-teal-600 font-bold text-lg">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="p-4 border-t border-gray-200 flex justify-between items-center">
                            <a href="{{ route('storefront.products.show', $product) }}" class="text-primary hover:underline text-sm font-medium">View Details</a>
                            <form method="POST" action="{{ route('storefront.cart.add', $product) }}" class="inline">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 text-sm font-medium {{ $product->isInStock() ? '' : 'opacity-50 cursor-not-allowed' }}" {{ $product->isInStock() ? '' : 'disabled' }}>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                        <!-- Category Tag -->
                        @if ($product->category)
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600 text-lg">No products found. Try adjusting your filters or search.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $products->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>