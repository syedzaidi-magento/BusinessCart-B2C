@extends('layouts.admin')

@section('title', 'Manage Attribute Keys')
@section('page-title', 'Manage Attribute Keys')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Attribute Keys</h2>
            <a href="{{ route('admin.attribute-keys.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Add New Attribute Key</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Model Type</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Key Name</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Data Type</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Required</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keys as $key)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $key->model_type }}</td>
                            <td class="p-3 text-gray-700">{{ $key->key_name }}</td>
                            <td class="p-3 text-gray-700">{{ ucfirst($key->data_type) }}</td>
                            <td class="p-3 text-gray-700">{{ $key->is_required ? 'Yes' : 'No' }}</td>
                            <td class="p-3 flex space-x-2">
                                <a href="{{ route('admin.attribute-keys.edit', $key) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                                <form action="{{ route('admin.attribute-keys.destroy', $key) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-gray-600 text-center">No attribute keys found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection