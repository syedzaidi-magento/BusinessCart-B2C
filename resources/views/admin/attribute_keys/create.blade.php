@extends('layouts.admin')

@section('title', 'Create Attribute Key')
@section('page-title', 'Create Attribute Key')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.attribute-keys.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="model_type" class="block text-gray-700 font-medium mb-2">Model Type</label>
                    <select name="model_type" id="model_type" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('model_type') border-red-500 @enderror">
                        <option value="">Select Model Type</option>
                        @foreach ($modelTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('model_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('model_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="key_name" class="block text-gray-700 font-medium mb-2">Key Name</label>
                    <input type="text" name="key_name" id="key_name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('key_name') border-red-500 @enderror" value="{{ old('key_name') }}">
                    @error('key_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_type" class="block text-gray-700 font-medium mb-2">Data Type</label>
                    <select name="data_type" id="data_type" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('data_type') border-red-500 @enderror">
                        <option value="string" {{ old('data_type') == 'string' ? 'selected' : '' }}>String</option>
                        <option value="integer" {{ old('data_type') == 'integer' ? 'selected' : '' }}>Integer</option>
                        <option value="boolean" {{ old('data_type') == 'boolean' ? 'selected' : '' }}>Boolean</option>
                    </select>
                    @error('data_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_required" class="block text-gray-700 font-medium mb-2">Required</label>
                    <input type="checkbox" name="is_required" id="is_required" value="1" class="h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded" {{ old('is_required') ? 'checked' : '' }}>
                    @error('is_required')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save Attribute Key</button>
                </div>
            </div>
        </form>
    </div>
@endsection