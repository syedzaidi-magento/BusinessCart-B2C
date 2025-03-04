@extends('layouts.admin')

@section('title', 'Edit Shelf')
@section('page-title', 'Edit Shelf: ' . $shelf->shelf_name)

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.shelves.update', $shelf) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="warehouse_id" class="block text-gray-700 font-medium mb-2">Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('warehouse_id') border-red-500 @enderror">
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $shelf->warehouse_id) == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="shelf_name" class="block text-gray-700 font-medium mb-2">Shelf Name</label>
                    <input type="text" name="shelf_name" id="shelf_name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('shelf_name') border-red-500 @enderror" value="{{ old('shelf_name', $shelf->shelf_name) }}">
                    @error('shelf_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Update Shelf</button>
                </div>
            </div>
        </form>
    </div>
@endsection