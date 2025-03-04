@extends('layouts.storefront')

@section('title', 'Cart')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Your Shopping Cart</h2>

            @if (session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border-l-4 border-red-500">
                    {{ session('error') }}
                </div>
            @endif

            @if (empty($cart))
                <div class="text-center bg-white shadow-md rounded-lg p-8">
                    <p class="text-gray-600 text-lg mb-4">Your cart is currently empty.</p>
                    <a href="{{ route('storefront.products.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary text-lg font-semibold">Continue Shopping</a>
                </div>
            @else
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <div class="space-y-6">
                        @foreach ($products as $product)
                            <div class="flex items-center border-b border-gray-200 pb-6">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-gray-600">Type: {{ ucfirst($product->type) }}</p>
                                </div>
                                <div class="w-32 text-center">
                                    @if ($product->getEffectivePrice($cart[$product->id]) < $product->price)
                                        <p class="text-gray-500 line-through">${{ number_format($product->price, 2) }}</p>
                                        <p class="text-teal-600 font-bold">${{ number_format($product->getEffectivePrice($cart[$product->id]), 2) }}</p>
                                    @else
                                        <p class="text-teal-600 font-bold">${{ number_format($product->getEffectivePrice($cart[$product->id]), 2) }}</p>
                                    @endif
                                </div>
                                <div class="w-32 text-center">
                                    <form method="POST" action="{{ route('storefront.cart.update') }}" class="inline-block">
                                        @csrf
                                        <input type="number" name="quantities[{{ $product->id }}]" min="0" value="{{ $cart[$product->id] }}" class="w-20 p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                                    </form>
                                </div>
                                <div class="w-32 text-center">
                                    <p class="text-gray-700 font-medium">${{ number_format($product->getEffectivePrice($cart[$product->id]) * $cart[$product->id], 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <form method="POST" action="{{ route('storefront.cart.index') }}" class="mb-4">
                            @csrf
                            <div class="flex items-center space-x-4">
                                <label for="coupon_code" class="text-gray-700 font-medium">Coupon Code</label>
                                <input type="text" name="coupon_code" id="coupon_code" class="w-48 p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ old('coupon_code', session('applied_coupon')) }}">
                                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Apply Coupon</button>
                            </div>
                        </form>

                        <div class="flex justify-between items-center mb-6">
                            <p class="text-xl font-semibold text-gray-900">Subtotal</p>
                            <p class="text-xl font-bold text-teal-600">${{ number_format($products->sum(fn($p) => $p->getEffectivePrice($cart[$p->id]) * $cart[$p->id]), 2) }}</p>
                        </div>
                        @if ($discount > 0)
                            <div class="flex justify-between items-center mb-6">
                                <p class="text-xl font-semibold text-gray-900">Discount</p>
                                <p class="text-xl font-bold text-red-600">-${{ number_format($discount, 2) }}</p>
                            </div>
                        @endif
                        <div class="flex justify-between items-center mb-6">
                            <p class="text-xl font-semibold text-gray-900">Total</p>
                            <p class="text-xl font-bold text-teal-600">${{ number_format($cartTotal, 2) }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <form method="POST" action="{{ route('storefront.cart.update') }}">
                                @csrf
                                <button type="submit" class="bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600 text-lg font-semibold">Update Cart</button>
                            </form>
                            <a href="{{ route('storefront.checkout.index') }}" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary text-lg font-semibold">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection