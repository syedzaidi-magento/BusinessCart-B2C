<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8 text-center">
                <h1 class="text-3xl font-semibold text-gray-800 mb-4">Order Placed Successfully!</h1>
                <p class="text-gray-600 mb-6">Thank you for your order. Here are the details:</p>

                <div class="bg-gray-50 p-6 rounded-lg shadow-inner max-w-md mx-auto">
                    <dl class="space-y-4">
                        <div class="flex justify-between text-gray-700">
                            <dt class="font-medium">Order ID</dt>
                            <dd>{{ $order->id }}</dd>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <dt class="font-medium">Total</dt>
                            <dd>${{ number_format($order->total, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <dt class="font-medium">Payment Method</dt>
                            <dd>{{ ucwords(str_replace('_', ' ', $order->custom_attributes['payment_method'])) }}</dd>
                        </div>
                        @if ($order->custom_attributes['payment_method'] === 'purchase_order')
                            <div class="flex justify-between text-gray-700">
                                <dt class="font-medium">PO Number</dt>
                                <dd>{{ $order->custom_attributes['po_number'] ?? 'N/A' }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between text-gray-700">
                            <dt class="font-medium">Shipping Method</dt>
                            <dd>{{ ucwords($order->custom_attributes['shipping_method']) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8">
                    <a href="{{ route('storefront.products.index') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary text-lg font-semibold transition-colors duration-200">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>