<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
            <h2 class="text-xl font-bold mb-4">Your Wishlist</h2>
            
            @if (session('success'))
                <div class="mt-4 bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div>
            @endif

            @if ($wishlistItems->isNotEmpty())
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left text-gray-700 font-semibold">Product</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Price</th>
                            <th class="p-3 text-left text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wishlistItems as $item)
                            <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-3 text-gray-700">{{ $item->product->name }}</td>
                                <td class="p-3 text-red-800 font-bold">${{ number_format($item->product->price, 2) }}</td>
                                <td class="p-3 flex space-x-2">
                                    <form action="{{ route('wishlist.move-to-cart', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-[var(--primary-color)] text-white px-3 py-1 rounded-lg hover:bg-[var(--primary-color-dark)] transition-colors duration-200">
                                            Add to Cart
                                        </button>
                                    </form>
                                    <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-800 transition-colors duration-200">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-gray-600 text-center">No items in your wishlist.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No items found in your wishlist.</p>
            @endif
        </div>
    </div>
</x-app-layout>