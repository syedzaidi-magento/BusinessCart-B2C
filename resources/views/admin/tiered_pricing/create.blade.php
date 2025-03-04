@extends('layouts.admin')

@section('title', 'Create Tiered Pricing')
@section('page-title', 'Create Tiered Pricing')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.tiered-pricing.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="product_id" class="block text-gray-700 font-medium mb-2">Product</label>
                    <select name="product_id" id="product_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('product_id') border-red-500 @enderror">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="min_quantity" class="block text-gray-700 font-medium mb-2">Minimum Quantity</label>
                    <input type="number" name="min_quantity" id="min_quantity" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('min_quantity') border-red-500 @enderror" value="{{ old('min_quantity') }}" min="1">
                    @error('min_quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price" class="block text-gray-700 font-medium mb-2">Price ($)</label>
                    <input type="number" name="price" id="price" step="0.01" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('price') border-red-500 @enderror" value="{{ old('price') }}">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Create Tier</button>
                </div>
            </div>
        </form>
    </div>
@endsection