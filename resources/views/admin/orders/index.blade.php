@extends('layouts.admin')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('content')
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Order List</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">ID</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">User</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Status</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Total</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $order->id }}</td>
                            <td class="p-3 text-gray-700">{{ $order->user->name }}</td>
                            <td class="p-3 text-gray-700">{{ $order->status }}</td>
                            <td class="p-3 text-gray-700">${{ number_format($order->total, 2) }}</td>
                            <td class="p-3 flex space-x-2">
                                <a href="{{ route('admin.orders.edit', $order) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-gray-600 text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection