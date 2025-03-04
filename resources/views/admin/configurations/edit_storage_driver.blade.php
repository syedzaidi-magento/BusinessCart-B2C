@extends('layouts.admin')

@section('title', 'Edit Storage Driver')
@section('page-title', 'Edit Storage Driver')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form action="{{ route('admin.configurations.updateStorageDriver') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="value" class="block text-gray-700 font-medium mb-2">Storage Driver</label>
                    <select name="value" id="value" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('value') border-red-500 @enderror">
                        <option value="local" {{ $config->value === 'local' ? 'selected' : '' }}>Local Storage</option>
                        <option value="s3" {{ $config->value === 's3' ? 'selected' : '' }}>Amazon S3</option>
                    </select>
                    @error('value')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Update Driver</button>
                </div>
            </div>
        </form>
    </div>
@endsection