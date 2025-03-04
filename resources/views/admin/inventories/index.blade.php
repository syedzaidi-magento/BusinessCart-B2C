@extends('layouts.admin')

@section('title', 'Manage Inventory')
@section('page-title', 'Manage Inventory')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Inventory</h2>
            <a href="{{ route('admin.inventories.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Add New Inventory</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Product</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Warehouse</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Shelf</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Quantity</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventories as $inventory)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $inventory->product->name }}</td>
                            <td class="p-3 text-gray-700">{{ $inventory->warehouse->name }}</td>
                            <td class="p-3 text-gray-700">{{ $inventory->shelf->shelf_name }}</td>
                            <td class="p-3 text-gray-700">{{ $inventory->quantity }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.inventories.edit', $inventory) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-gray-600 text-center">No inventory records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
@endsection