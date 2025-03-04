@extends('layouts.storefront')

@section('title', 'Checkout')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Checkout</h2>
        <form method="POST" action="{{ route('storefront.checkout.index') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="warehouse_id" class="block text-gray-700 font-medium mb-2">Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('warehouse_id') border-red-500 @enderror">
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="shelf_id" class="block text-gray-700 font-medium mb-2">Shelf</label>
                    <select name="shelf_id" id="shelf_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('shelf_id') border-red-500 @enderror">
                        @foreach ($warehouses as $warehouse)
                            @foreach ($warehouse->shelves as $shelf)
                                <option value="{{ $shelf->id }}">{{ $shelf->shelf_name }} ({{ $warehouse->name }})</option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('shelf_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <p class="text-gray-700 font-medium">Total: ${{ number_format($total, 2) }}</p>
                </div>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Place Order</button>
            </div>
        </form>
    </div>
@endsection