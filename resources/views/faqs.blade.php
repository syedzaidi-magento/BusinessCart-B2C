<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Frequently Asked Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- FAQs Section -->
            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">FAQs</h1>
                    <p class="text-lg text-gray-700 mb-6">
                        Got questions? We’ve got answers! Browse our frequently asked questions below to learn more about shopping with {{ config('app.name', 'Your Store') }}.
                    </p>
                    <div class="space-y-4">
                        @foreach ([
                            [
                                'question' => 'How long does shipping take?',
                                'answer' => 'Shipping typically takes 3-7 business days within the US, depending on your location. Expedited options are available at checkout!'
                            ],
                            [
                                'question' => 'What is your return policy?',
                                'answer' => 'We offer a 30-day return policy. Items must be unused and in their original packaging. Contact us at support@{{ config(\'app.name\', \'yourstore\') }}.com to start a return.'
                            ],
                            [
                                'question' => 'What payment methods do you accept?',
                                'answer' => 'We accept all major credit cards (Visa, MasterCard, Amex), PayPal, and Apple Pay. Secure checkout is guaranteed!'
                            ],
                            [
                                'question' => 'How can I track my order?',
                                'answer' => 'Once your order ships, you’ll receive a tracking number via email. You can also check your order status in your account dashboard.'
                            ],
                            [
                                'question' => 'Do you ship internationally?',
                                'answer' => 'Yes! We ship to many countries worldwide. Shipping costs and times vary by destination—see details at checkout.'
                            ],
                            [
                                'question' => 'How do I contact customer support?',
                                'answer' => 'Reach us via email at support@{{ config(\'app.name\', \'yourstore\') }}.com or call (123) 456-7890, Mon-Fri, 9 AM - 5 PM.'
                            ]
                        ] as $faq)
                            <div class="border-b border-gray-200">
                                <details class="group">
                                    <summary class="flex justify-between items-center py-4 cursor-pointer text-gray-900 font-semibold text-lg hover:text-[var(--primary-color)] transition-colors duration-200">
                                        {{ $faq['question'] }}
                                        <svg class="w-5 h-5 text-[var(--primary-color)] transform group-open:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </summary>
                                    <p class="text-gray-700 pb-4 pl-4">
                                        {{ $faq['answer'] }}
                                    </p>
                                </details>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        <p class="text-gray-700">Still have questions? <a href="{{ route('contact') }}" class="text-[var(--primary-color)] hover:underline">Contact us</a> for more help!</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>