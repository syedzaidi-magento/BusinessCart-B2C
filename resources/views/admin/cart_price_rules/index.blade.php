@extends('layouts.admin')

@section('title', 'Cart Price Rules')
@section('page-title', 'Cart Price Rules')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Cart Price Rules</h2>
            <a href="{{ route('admin.cart-price-rules.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Add New Rule</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left text-gray-700 font-semibold">Name</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Coupon Code</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Type</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Value</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Active</th>
                        <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rules as $rule)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-3 text-gray-700">{{ $rule->name }}</td>
                            <td class="p-3 text-gray-700">{{ $rule->coupon_code ?? 'N/A' }}</td>
                            <td class="p-3 text-gray-700">{{ ucfirst(str_replace('_', ' ', $rule->type)) }}</td>
                            <td class="p-3 text-gray-700">
                                @if ($rule->type === 'percentage')
                                    {{ $rule->discount_value }}%
                                @elseif ($rule->type === 'fixed')
                                    ${{ number_format($rule->discount_value, 2) }}
                                @elseif ($rule->type === 'buy_x_get_y_free')
                                    Buy {{ $rule->buy_quantity }} Get {{ $rule->free_quantity }} Free
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="p-3 text-gray-700">{{ $rule->is_active ? 'Yes' : 'No' }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.cart-price-rules.edit', $rule) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-3 text-gray-600 text-center">No rules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection