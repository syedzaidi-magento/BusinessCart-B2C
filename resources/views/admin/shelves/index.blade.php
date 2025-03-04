@extends('layouts.admin')

@section('title', 'Manage Shelves')
@section('page-title', 'Manage Shelves')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Shelves</h2>
            <a href="{{ route('admin.shelves.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Add New Shelf</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Shelf Name</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Warehouse</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shelves as $shelf)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $shelf->shelf_name }}</td>
                            <td class="p-3 text-gray-700">{{ $shelf->warehouse->name }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.shelves.edit', $shelf) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-3 text-gray-600 text-center">No shelves found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection