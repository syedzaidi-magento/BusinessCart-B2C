@extends('layouts.admin')

@section('title', 'Tiered Pricing')
@section('page-title', 'Tiered Pricing')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Tiered Pricing</h2>
            <a href="{{ route('admin.tiered-pricing.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Add New Tier</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Product</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Min Quantity</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Price</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tiers as $tier)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $tier->product->name }}</td>
                            <td class="p-3 text-gray-700">{{ $tier->min_quantity }}</td>
                            <td class="p-3 text-gray-700">${{ number_format($tier->price, 2) }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.tiered-pricing.edit', $tier) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-gray-600 text-center">No tiered pricing found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $tiers->links() }}
            </div>
        </div>
    </div>
@endsection