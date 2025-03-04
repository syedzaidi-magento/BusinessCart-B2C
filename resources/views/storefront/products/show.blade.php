@extends('layouts.storefront')

@section('title', $product->name)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            @if ($product->images->isNotEmpty())
            <img src="{{ $product->images->where('is_main', true)->first()->url ?? $product->images->first()->url }}"
                 alt="{{ $product->images->where('is_main', true)->first()->alt_text ?? 'Product Image' }}"
                 loading="lazy"
                 class="w-full h-64 object-cover mb-4">
            <div class="flex space-x-2">
                @foreach ($product->images as $image)
                    <img src="{{ $image->url }}"
                         alt="{{ $image->alt_text }}"
                         loading="lazy"
                         class="w-16 h-16 object-cover">
                @endforeach
            </div>
        @endif
            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-2">Type: {{ ucfirst($product->type) }}</p>
            <div class="mb-4">
                @if ($product->getEffectivePrice() < $product->price)
                    <p class="text-gray-500 line-through text-xl">${{ number_format($product->price, 2) }}</p>
                    <p class="text-teal-600 font-bold text-xl">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                @else
                    <p class="text-teal-600 font-bold text-xl">${{ number_format($product->getEffectivePrice(), 2) }}</p>
                @endif
            </div>
            <p class="text-gray-700 mb-4">
                {{ $product->isInStock() ? 'In Stock' : 'Out of Stock' }} 
                ({{ $product->inventory && $product->inventory->quantity > 0 ? $product->inventory->quantity : 0 }} available)
            </p>
            @if ($product->description)
                <p class="text-gray-700 mb-4">{{ $product->description }}</p>
            @endif
            @if ($attributeKeys->isNotEmpty())
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Attributes</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($attributeKeys as $key)
                            @if (isset($product->custom_attributes[$key->key_name]))
                                <li>{{ ucfirst($key->key_name) }}: {{ $product->custom_attributes[$key->key_name] }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('storefront.cart.add', $product) }}">
                @csrf
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" 
                           value="1" 
                           max="{{ $product->inventory && $product->inventory->quantity > 0 ? $product->inventory->quantity : 1 }}" 
                           class="w-20 p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                           {{ $product->isInStock() ? '' : 'disabled' }}>
                </div>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" 
                        {{ $product->isInStock() ? '' : 'disabled' }}>Add to Cart</button>
            </form>
            @if ($product->type === 'configurable' && $product->variations->isNotEmpty())
                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-800">Variations</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($product->variations as $variation)
                            <li>{{ $variation->attribute }}: {{ $variation->value }} (+${{ number_format($variation->price_adjustment, 2) }})</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (in_array($product->type, ['grouped', 'bundle']) && $product->relatedProducts->isNotEmpty())
                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-800">Related Products</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($product->relatedProducts as $related)
                            <li>{{ $related->name }} - ${{ number_format($related->getEffectivePrice(), 2) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection