@extends('layouts.admin')

@section('title', 'Create Catalog Price Rule')
@section('page-title', 'Create Catalog Price Rule')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.catalog-price-rules.store') }}">
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
                    <label for="discount_percentage" class="block text-gray-700 font-medium mb-2">Discount Percentage (%)</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" step="0.01" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('discount_percentage') border-red-500 @enderror" value="{{ old('discount_percentage') }}">
                    @error('discount_percentage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="discount_amount" class="block text-gray-700 font-medium mb-2">Discount Amount ($)</label>
                    <input type="number" name="discount_amount" id="discount_amount" step="0.01" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('discount_amount') border-red-500 @enderror" value="{{ old('discount_amount') }}">
                    @error('discount_amount')
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
                    <label for="products" class="block text-gray-700 font-medium mb-2">Products</label>
                    <select name="products[]" id="products" multiple class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('products') border-red-500 @enderror">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('products')
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