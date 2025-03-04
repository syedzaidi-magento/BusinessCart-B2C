@extends('layouts.admin')

@section('title', 'Edit Inventory')
@section('page-title', 'Edit Inventory for ' . $inventory->product->name)

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.inventories.update', $inventory) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="product_id" class="block text-gray-700 font-medium mb-2">Product</label>
                    <select name="product_id" id="product_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('product_id') border-red-500 @enderror">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $inventory->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="warehouse_id" class="block text-gray-700 font-medium mb-2">Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('warehouse_id') border-red-500 @enderror">
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $inventory->warehouse_id) == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="shelf_id" class="block text-gray-700 font-medium mb-2">Shelf</label>
                    <select name="shelf_id" id="shelf_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('shelf_id') border-red-500 @enderror">
                        @foreach ($shelves as $shelf)
                            <option value="{{ $shelf->id }}" {{ old('shelf_id', $inventory->shelf_id) == $shelf->id ? 'selected' : '' }}>{{ $shelf->shelf_name }} ({{ $shelf->warehouse->name }})</option>
                        @endforeach
                    </select>
                    @error('shelf_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('quantity') border-red-500 @enderror" value="{{ old('quantity', $inventory->quantity) }}" min="0">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Update Inventory</button>
                </div>
            </div>
        </form>
    </div>
@endsection