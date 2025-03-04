@extends('layouts.admin')

@section('title', 'Manage Products')
@section('page-title', 'Manage Products')

@section('content')
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('admin.products.bulk-delete') }}" id="bulk-delete-form">
            @csrf
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Product List</h2>
                <div class="flex space-x-4 items-center">
                    <div class="flex items-center">
                        <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center">
                            <input type="text" name="search" placeholder="Search products..." class="p-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" value="{{ request('search') }}">
                            <button type="submit" class="ml-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200">Search</button>
                        </form>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200" onclick="return confirm('Are you sure you want to delete selected products?')">Delete Selected</button>
                    <a href="{{ route('admin.products.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Add New Product</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left text-gray-700 font-semibold"><input type="checkbox" id="select-all"></th>
                            <th>Image</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Name</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Type</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Price</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Quantity</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Store</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Details</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-3"><input type="checkbox" name="ids[]" value="{{ $product->id }}" class="select-item h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded"></td>
                                <td>
                                    @if ($product->images->isNotEmpty())
                                        <img src="{{ $product->images->where('is_main', true)->first()->url ?? $product->images->first()->url }}"
                                             alt="{{ $product->images->where('is_main', true)->first()->alt_text ?? 'Product Image' }}"
                                             class="w-16 h-16 object-cover">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td class="p-3 text-gray-700">{{ $product->name }}</td>
                                <td class="p-3 text-gray-700">{{ ucfirst($product->type) }}</td>
                                <td class="p-3 text-gray-700">${{ number_format($product->price, 2) }}</td>
                                <td class="p-3 text-gray-700 {{ $product->isInStock() ? 'text-green-600' : 'text-red-600' }}">{{ $product->quantity }}</td>
                                <td class="p-3 text-gray-700">{{ $product->store ? $product->store->name : 'N/A' }}</td>
                                <td class="p-3 text-gray-600">
                                    @if ($product->type === 'configurable' && $product->variations->isNotEmpty())
                                        <ul class="list-disc pl-4">
                                            @foreach ($product->variations as $variation)
                                                <li>{{ $variation->attribute }}: {{ $variation->value }} (+${{ number_format($variation->price_adjustment, 2) }}) - Qty: {{ $variation->quantity }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (in_array($product->type, ['grouped', 'bundle']) && $product->relatedProducts->isNotEmpty())
                                        <ul class="list-disc pl-4">
                                            @foreach ($product->relatedProducts as $related)
                                                <li>{{ $related->name }} (Qty: {{ $related->quantity }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="p-3 flex space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors duration-200" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-3 text-gray-600 text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            document.querySelectorAll('.select-item').forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection