@extends('layouts.admin')

@section('title', 'Create User')
@section('page-title', 'Create User')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form action="{{ route('admin.users.store') }}" method="POST">
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
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                </div>

                <div>
                    <label for="is_admin" class="block text-gray-700 font-medium mb-2">Admin</label>
                    <input type="checkbox" name="is_admin" id="is_admin" value="1" class="h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded" {{ old('is_admin') ? 'checked' : '' }}>
                    @error('is_admin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save User</button>
                </div>
            </div>
        </form>
    </div>
@endsection