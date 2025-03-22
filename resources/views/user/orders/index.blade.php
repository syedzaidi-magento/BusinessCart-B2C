<x-app-layout>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold mb-4">Your Orders</h2>
        @if ($orders->isNotEmpty())
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
                            <a href="{{ route('storefront.order.success', $order) }}" class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors duration-200">Order Details</a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-3 text-gray-600 text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @else
            <p class="text-gray-500">No addresses found.</p>
        @endif
    </div>
</div>
</x-app-layout>