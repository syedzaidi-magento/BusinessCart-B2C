@extends('layouts.admin')

@section('title', 'Manage Configurations')
@section('page-title', 'Manage Configurations')

@section('content')
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Configuration List</h2>
            <div>
                <a href="{{ route('admin.configurations.editStorageDriver') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-teal-600 transition-colors duration-200 mr-2">Edit Storage Driver</a>
                {{-- <a href="{{ route('admin.configurations.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Add New Configuration</a> --}}
            </div>
        </div>

        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Configuration Settings</h1>
            <form method="POST" action="{{ route('admin.configurations.update', $storeId) }}">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($configs as $key => $config)
                        <div class="bg-white p-4 rounded-lg shadow">
                            <label class="block text-gray-700 font-medium mb-2">{{ $config['definition']['description'] }}</label>
                            @if ($config['definition']['type'] === 'boolean')
                                <input type="checkbox" name="configs[{{ $key }}]" value="1" {{ $config['value'] ? 'checked' : '' }} class="h-4 w-4">
                            @elseif ($config['definition']['type'] === 'decimal')
                                <input type="number" step="0.01" name="configs[{{ $key }}]" value="{{ $config['value'] }}" class="w-full p-2 border rounded-lg">
                            @else
                                <input type="text" name="configs[{{ $key }}]" value="{{ $config['value'] }}" class="w-full p-2 border rounded-lg">
                            @endif
                            @error("configs.$key")
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Save Changes</button>
            </form>
        </div>
    </div>
@endsection