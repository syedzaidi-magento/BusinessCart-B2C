@extends('layouts.storefront')

@section('title', 'Shop')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-gray-900 mb-8 text-center">Shop Our Products</h2>
            
            <div class="mb-8">
                <label for="category_id" class="block text-gray-700 font-medium mb-2">Filter by Category</label>
                <form method="GET" action="{{ route('storefront.products.index') }}">
                    <select name="category_id" id="category_id" class="w-full max-w-xs p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-4">
                            @if ($product->images->isNotEmpty())
                            <img src="{{ $product->images->where('is_main', true)->first()->url ?? $product->images->first()->url }}"
                                 alt="{{ $product->images->where('is_main', true)->first()->alt_text ?? 'Product Image' }}"
                                 loading="lazy"
                                 class="w-full h-48 object-cover mb-2">
                        @endif
                        <h2 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h2>                            
                            <p class="text-gray-600">{{ ucfirst($product->type) }}</p>
                            <div class="mt-2">
                                @if ($product->getEffectivePrice() < $product->price)
                                    <p class="text-gray-500 line-through">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-teal-600 font-bold">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                                @else
                                    <p class="text-teal-600 font-bold">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-200">
                            <a href="{{ route('storefront.products.show', $product) }}" class="text-primary hover:underline">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection