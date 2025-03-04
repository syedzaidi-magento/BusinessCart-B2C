@extends('layouts.admin')

@section('title', 'Manage Stores')
@section('page-title', 'Manage Stores')

@section('content')
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Store List</h2>
            <a href="{{ route('admin.stores.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Add New Store</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Name</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Description</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stores as $store)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $store->name }}</td>
                            <td class="p-3 text-gray-600">{{ $store->description }}</td>
                            <td class="p-3 flex space-x-2">
                                <a href="{{ route('admin.stores.edit', $store) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                                <form action="{{ route('admin.stores.destroy', $store) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-3 text-gray-600 text-center">No stores found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection