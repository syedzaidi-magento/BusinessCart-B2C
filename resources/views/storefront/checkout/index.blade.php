<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="mb-10">
                <h2 class="text-3xl font-semibold text-gray-800 text-center">Checkout</h2>
                <p class="mt-2 text-sm text-gray-600 text-center">Complete your order securely and efficiently</p>
            </header>

            <div class="bg-white shadow-lg rounded-lg p-8">
                <form method="POST" action="{{ route('storefront.checkout.index') }}" id="payment-form" class="space-y-10">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column: Shipping and Address Options -->
                        <div class="space-y-10">
                            <!-- Shipping Method -->
                            <section class="border-b border-gray-200 pb-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Shipping Method</h3>
                                <div class="space-y-4">
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                        <input type="radio" name="shipping_method" value="pickup" checked class="mr-3 text-primary focus:ring-primary h-5 w-5">
                                        <span class="text-gray-700 font-medium">Warehouse Pickup</span>
                                    </label>
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                        <input type="radio" name="shipping_method" value="delivery" class="mr-3 text-primary focus:ring-primary h-5 w-5">
                                        <span class="text-gray-700 font-medium">Delivery</span>
                                    </label>
                                </div>
                            </section>

                            <!-- Pickup Options -->
                            <section id="pickup-options" class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Pickup Location</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-2">Warehouse</label>
                                        <select name="warehouse_id" id="warehouse_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('warehouse_id') border-red-500 @enderror">
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="shelf_id" class="block text-sm font-medium text-gray-700 mb-2">Shelf</label>
                                        <select name="shelf_id" id="shelf_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('shelf_id') border-red-500 @enderror">
                                            @foreach ($warehouses as $warehouse)
                                                @foreach ($warehouse->shelves as $shelf)
                                                    <option value="{{ $shelf->id }}">{{ $shelf->shelf_name }} ({{ $warehouse->name }})</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('shelf_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </section>

                            <!-- Shipping Address -->
                            <section id="delivery-options" class="hidden space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Shipping Address</h3>
                                <div>
                                    <label for="shipping_address_id" class="block text-sm font-medium text-gray-700 mb-2">Select Address</label>
                                    <select name="shipping_address_id" id="shipping_address_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('shipping_address_id') border-red-500 @enderror">
                                        @foreach (auth()->user()->addresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                                {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shipping_address_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                            </section>

                            <!-- Billing Address -->
                            <section class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Billing Address</h3>
                                <div>
                                    <label for="billing_address_id" class="block text-sm font-medium text-gray-700 mb-2">Select Address</label>
                                    <select name="billing_address_id" id="billing_address_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('billing_address_id') border-red-500 @enderror">
                                        @foreach (auth()->user()->addresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                                {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('billing_address_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </section>
                        </div>

                        <!-- Right Column: Payment and Order Summary -->
                        <div class="space-y-10">
                            <!-- Payment Methods -->
                            <section class="border-b border-gray-200 pb-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Payment Method</h3>
                                <div class="space-y-4">
                                    @foreach ($paymentMethods as $method)
                                        <label class="flex items-center p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                            <input type="radio" name="payment_method" value="{{ $method }}" class="mr-3 text-primary focus:ring-primary h-5 w-5" {{ $loop->first ? 'checked' : '' }}>
                                            <span class="text-gray-700 font-medium">{{ $paymentMethodLabels[$method] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror

                                <!-- Payment Elements -->
                                <div id="payment-elements" class="mt-4 space-y-4">
                                    @if (in_array('amazon_pay', $paymentMethods))
                                        <div id="amazon-pay-button" class="hidden" data-method="amazon_pay">
                                            <div id="addressBookWidget" class="w-full h-64"></div>
                                            <div id="walletWidget" class="w-full h-64 mt-4"></div>
                                            <input type="hidden" name="order_reference_id" id="order_reference_id">
                                        </div>
                                    @endif
                                    @if (in_array('google_pay', $paymentMethods))
                                        <div id="google-pay-button" class="hidden" data-method="google_pay"></div>
                                        <input type="hidden" name="payment_token" id="payment_token">
                                    @endif
                                    @if (in_array('stripe', $paymentMethods))
                                        <div id="stripe-card-element" class="hidden p-3 bg-white border border-gray-300 rounded-lg" data-method="stripe"></div>
                                        <input type="hidden" name="payment_method_id" id="payment_method_id">
                                    @endif
                                    @if (in_array('purchase_order', $paymentMethods))
                                        <div id="po-number-element" class="hidden" data-method="purchase_order">
                                            <label for="po_number" class="block text-sm font-medium text-gray-700 mb-2">PO Number</label>
                                            <input type="text" name="po_number" id="po_number" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('po_number') border-red-500 @enderror" placeholder="Enter your PO number">
                                            @error('po_number')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </section>

                            <!-- Order Summary -->
                            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6">Order Summary</h3>
                                <dl class="space-y-4">
                                    <div class="flex justify-between text-gray-700">
                                        <dt>Subtotal</dt>
                                        <dd>$<span id="subtotal">{{ number_format($subtotal, 2) }}</span></dd>
                                    </div>
                                    <div class="flex justify-between text-gray-700">
                                        <dt>Shipping</dt>
                                        <dd>$<span id="shipping-cost">0.00</span></dd>
                                    </div>
                                    <div class="flex justify-between text-gray-700">
                                        <dt>Tax</dt>
                                        <dd>$<span id="tax">0.00</span></dd>
                                    </div>
                                    <div class="flex justify-between text-lg font-semibold text-gray-800 border-t border-gray-200 pt-4">
                                        <dt>Total</dt>
                                        <dd>$<span id="total">0.00</span></dd>
                                    </div>
                                </dl>
                                <button type="submit" id="submit-button" class="w-full mt-6 bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary text-lg font-semibold transition-colors duration-200">Place Order</button>
                            </section>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Conditionally Load Payment SDKs -->
    @if (in_array('google_pay', $paymentMethods))
        <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    @endif
    @if (in_array('stripe', $paymentMethods))
        <script src="https://js.stripe.com/v3/"></script>
    @endif
    @if (in_array('amazon_pay', $paymentMethods))
        <script src="https://static-na.payments-amazon.com/checkout.js"></script>
    @endif

    <script>
        const subtotal = {{ $subtotal }};
        const taxRate = {{ $taxRate }};
        const freeShippingEnabled = {{ $freeShippingEnabled ? 1 : 0 }};
        const freeShippingMin = {{ $freeShippingMin }};
        const flatRateEnabled = {{ $flatRateEnabled ? 1 : 0 }};
        const flatRateAmount = {{ $flatRateAmount }};
        const defaultShippingFee = 5.99;

        function calculateTotal() {
            console.log('calculateTotal called');
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked')?.value;
            console.log('Selected shipping method:', shippingMethod);
            let shippingCost = 0;
            if (shippingMethod === 'delivery') {
                if (flatRateEnabled) {
                    shippingCost = flatRateAmount;
                } else if (freeShippingEnabled) {
                    shippingCost = subtotal >= freeShippingMin ? 0 : defaultShippingFee;
                }
            }
            const tax = subtotal * taxRate;
            const total = subtotal + tax + shippingCost;

            document.getElementById('shipping-cost').textContent = shippingCost.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
            return total;
        }

        function toggleOptions() {
            console.log('toggleOptions called');
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked')?.value;
            console.log('Toggling for shipping method:', shippingMethod);
            document.getElementById('pickup-options').classList.toggle('hidden', shippingMethod !== 'pickup');
            document.getElementById('delivery-options').classList.toggle('hidden', shippingMethod !== 'delivery');
        }

        function togglePaymentElements() {
            console.log('togglePaymentElements called');
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
            console.log('Selected payment method:', selectedMethod);
            document.querySelectorAll('#payment-elements > div').forEach(element => {
                element.classList.toggle('hidden', element.dataset.method !== selectedMethod);
            });
        }

        document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
            console.log('Adding listener to shipping method input:', input.value);
            input.addEventListener('change', () => {
                toggleOptions();
                calculateTotal();
            });
        });

        document.querySelectorAll('input[name="payment_method"]').forEach(input => {
            console.log('Adding listener to payment method input:', input.value);
            input.addEventListener('change', togglePaymentElements);
        });

        toggleOptions();
        togglePaymentElements();
        calculateTotal();

        @if (in_array('amazon_pay', $paymentMethods))
            if (document.querySelector('input[value="amazon_pay"]')) {
                window.onAmazonLoginReady = function() {
                    amazon.Login.setClientId('{{ $paymentConfigs['amazon_pay']['client_id'] }}');
                };
                window.onAmazonPaymentsReady = function() {
                    new OffAmazonPayments.Widgets.AddressBook({
                        sellerId: '{{ $paymentConfigs['amazon_pay']['merchant_id'] }}',
                        onReady: function(orderReference) {
                            document.getElementById('order_reference_id').value = orderReference.getAmazonOrderReferenceId();
                            new OffAmazonPayments.Widgets.Wallet({
                                sellerId: '{{ $paymentConfigs['amazon_pay']['merchant_id'] }}',
                                amazonOrderReferenceId: orderReference.getAmazonOrderReferenceId(),
                                onPaymentSelect: calculateTotal,
                                design: { designMode: 'responsive' }
                            }).bind('walletWidget');
                        },
                        onError: function(error) {
                            console.error('Amazon Pay Error:', error.getErrorMessage());
                        }
                    }).bind('addressBookWidget');
                };
            }
        @endif

        @if (in_array('google_pay', $paymentMethods))
            const googlePayClient = new google.payments.api.PaymentsClient({ environment: 'TEST' });
            const googlePayConfig = {
                apiVersion: 2,
                apiVersionMinor: 0,
                allowedPaymentMethods: [{
                    type: 'CARD',
                    parameters: {
                        allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                        allowedCardNetworks: ['AMEX', 'DISCOVER', 'MASTERCARD', 'VISA']
                    },
                    tokenizationSpecification: {
                        type: 'PAYMENT_GATEWAY',
                        parameters: { gateway: 'example', gatewayMerchantId: 'exampleMerchantId' }
                    }
                }],
                merchantInfo: { merchantId: '12345678901234567890', merchantName: 'Your Store' },
                transactionInfo: { totalPriceStatus: 'FINAL', totalPrice: calculateTotal().toString(), currencyCode: 'USD' }
            };
            googlePayClient.isReadyToPay(googlePayConfig).then(function(response) {
                if (response.result) {
                    const button = googlePayClient.createButton({
                        onClick: () => {
                            googlePayClient.loadPaymentData(googlePayConfig).then(function(paymentData) {
                                document.getElementById('payment_token').value = paymentData.paymentMethodData.tokenizationData.token;
                                document.getElementById('payment-form').submit();
                            }).catch(function(err) {
                                console.error('Google Pay Error:', err);
                            });
                        }
                    });
                    document.getElementById('google-pay-button').appendChild(button);
                }
            }).catch(err => console.error('Google Pay Ready Error:', err));
        @endif

        @if (in_array('stripe', $paymentMethods))
            const stripe = Stripe('{{ $paymentConfigs['stripe']['publishable_key'] }}');
            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                style: {
                    base: { fontSize: '16px', color: '#32325d', '::placeholder': { color: '#aab7c4' } },
                    invalid: { color: '#fa755a' }
                }
            });
            cardElement.mount('#stripe-card-element');
        @endif

        document.getElementById('payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
            document.getElementById('submit-button').disabled = true;

            @if (in_array('stripe', $paymentMethods))
                if (paymentMethod === 'stripe') {
                    const { paymentMethod: stripePaymentMethod, error } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: cardElement,
                        billing_details: {
                            address: {
                                line1: '{{ auth()->user()->addresses->first()->address_line_1 ?? '' }}',
                                city: '{{ auth()->user()->addresses->first()->city ?? '' }}',
                                state: '{{ auth()->user()->addresses->first()->state ?? '' }}',
                                postal_code: '{{ auth()->user()->addresses->first()->postal_code ?? '' }}',
                            }
                        }
                    });

                    if (error) {
                        alert(error.message);
                        document.getElementById('submit-button').disabled = false;
                    } else {
                        document.getElementById('payment_method_id').value = stripePaymentMethod.id;
                        document.getElementById('payment-form').submit();
                    }
                    return;
                }
            @endif

            document.getElementById('payment-form').submit();
        });
    </script>
</x-app-layout>