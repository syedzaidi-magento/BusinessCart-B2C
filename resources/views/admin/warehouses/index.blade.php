@extends('layouts.admin')

@section('title', 'Manage Warehouses')
@section('page-title', 'Manage Warehouses')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Warehouses</h2>
            <a href="{{ route('admin.warehouses.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Add New Warehouse</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Name</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Address</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Contact</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $warehouse)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $warehouse->name }}</td>
                            <td class="p-3 text-gray-700">{{ $warehouse->street }}, {{ $warehouse->city }}, {{ $warehouse->state }} {{ $warehouse->zip }}, {{ $warehouse->country }}</td>
                            <td class="p-3 text-gray-700">{{ $warehouse->contact_details ?? 'N/A' }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-gray-600 text-center">No warehouses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
