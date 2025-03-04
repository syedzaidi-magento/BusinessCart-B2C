@extends('layouts.admin')

@section('title', 'Create Configuration')
@section('page-title', 'Create Configuration')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form action="{{ route('admin.configurations.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="key" class="block text-gray-700 font-medium mb-2">Key</label>
                    <input type="text" name="key" id="key" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('key') border-red-500 @enderror" value="{{ old('key') }}">
                    @error('key')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="value" class="block text-gray-700 font-medium mb-2">Value</label>
                    <input type="text" name="value" id="value" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('value') border-red-500 @enderror" value="{{ old('value') }}">
                    @error('value')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save Configuration</button>
                </div>
            </div>
        </form>
    </div>
@endsection