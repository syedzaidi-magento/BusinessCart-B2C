@extends('layouts.admin')

@section('title', 'Create Warehouse')
@section('page-title', 'Create Warehouse')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.warehouses.store') }}">
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
                    <label for="street" class="block text-gray-700 font-medium mb-2">Street</label>
                    <input type="text" name="street" id="street" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('street') border-red-500 @enderror" value="{{ old('street') }}">
                    @error('street')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
                    <input type="text" name="city" id="city" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('city') border-red-500 @enderror" value="{{ old('city') }}">
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="state" class="block text-gray-700 font-medium mb-2">State</label>
                    <input type="text" name="state" id="state" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('state') border-red-500 @enderror" value="{{ old('state') }}">
                    @error('state')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="zip" class="block text-gray-700 font-medium mb-2">Zip Code</label>
                    <input type="text" name="zip" id="zip" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('zip') border-red-500 @enderror" value="{{ old('zip') }}">
                    @error('zip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="country" class="block text-gray-700 font-medium mb-2">Country</label>
                    <input type="text" name="country" id="country" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('country') border-red-500 @enderror" value="{{ old('country') }}">
                    @error('country')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="contact_details" class="block text-gray-700 font-medium mb-2">Contact Details</label>
                    <textarea name="contact_details" id="contact_details" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('contact_details') border-red-500 @enderror">{{ old('contact_details') }}</textarea>
                    @error('contact_details')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save Warehouse</button>
                </div>
            </div>
        </form>
    </div>
@endsection
