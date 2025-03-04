@extends('layouts.admin')

@section('title', 'Create Store')
@section('page-title', 'Create Store')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form action="{{ route('admin.stores.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    @error('name')
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
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save Store</button>
                </div>
            </div>
        </form>
    </div>
@endsection