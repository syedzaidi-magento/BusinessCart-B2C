@extends('layouts.admin')

@section('title', 'Create Cart Price Rule')
@section('page-title', 'Create Cart Price Rule')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.cart-price-rules.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="coupon_code" class="block text-gray-700 font-medium mb-2">Coupon Code</label>
                    <input type="text" name="coupon_code" id="coupon_code" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('coupon_code') border-red-500 @enderror" value="{{ old('coupon_code') }}">
                    @error('coupon_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                    <select name="type" id="type" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror">
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage Discount</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Discount</option>
                        <option value="buy_x_get_y_free" {{ old('type') == 'buy_x_get_y_free' ? 'selected' : '' }}>Buy X Get Y Free</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="discount_value" class="block text-gray-700 font-medium mb-2">Discount Value</label>
                    <input type="number" name="discount_value" id="discount_value" step="0.01" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('discount_value') border-red-500 @enderror" value="{{ old('discount_value') }}">
                    @error('discount_value')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="buy_quantity" class="block text-gray-700 font-medium mb-2">Buy Quantity (for Buy X Get Y Free)</label>
                    <input type="number" name="buy_quantity" id="buy_quantity" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('buy_quantity') border-red-500 @enderror" value="{{ old('buy_quantity') }}">
                    @error('buy_quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="free_quantity" class="block text-gray-700 font-medium mb-2">Free Quantity (for Buy X Get Y Free)</label>
                    <input type="number" name="free_quantity" id="free_quantity" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('free_quantity') border-red-500 @enderror" value="{{ old('free_quantity') }}">
                    @error('free_quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="min_cart_total" class="block text-gray-700 font-medium mb-2">Minimum Cart Total ($)</label>
                    <input type="number" name="min_cart_total" id="min_cart_total" step="0.01" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('min_cart_total') border-red-500 @enderror" value="{{ old('min_cart_total') }}">
                    @error('min_cart_total')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}">
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="is_active" class="block text-gray-700 font-medium mb-2">Active</label>
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded" {{ old('is_active', 1) ? 'checked' : '' }}>
                    @error('is_active')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Create Rule</button>
                </div>
            </div>
        </form>
    </div>
@endsection