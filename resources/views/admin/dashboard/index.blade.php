@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600">Here’s a quick overview of your admin panel as of {{ now()->format('F j, Y') }}.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-teal-100 rounded-full">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Total Products</h3>
                        <p class="text-2xl text-gray-700">{{ $stats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">In Stock</h3>
                        <p class="text-2xl text-gray-700">{{ $stats['products_in_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Out of Stock</h3>
                        <p class="text-2xl text-gray-700">{{ $stats['products_out_of_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-teal-100 rounded-full">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Total Orders</h3>
                        <p class="text-2xl text-gray-700">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Recent Orders</h2>
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
                        @forelse ($stats['recent_orders'] as $order)
                            <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-3 text-gray-700">{{ $order->id }}</td>
                                <td class="p-3 text-gray-700">{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                <td class="p-3 text-gray-700">
                                    <span class="inline-block px-2 py-1 text-sm rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-700">${{ number_format($order->total, 2) }}</td>
                                <td class="p-3">
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="text-teal-600 hover:text-teal-800 transition-colors duration-200">View/Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-gray-600 text-center">No recent orders.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection