<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Introduction Section -->
            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Welcome to {{ config('app.name', 'Your Store') }}</h1>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        At {{ config('app.name', 'Your Store') }}, we’re passionate about bringing you the best products at unbeatable prices. Founded with a vision to simplify online shopping, we’ve grown into a trusted destination for quality goods, from electronics to fashion and beyond. Our commitment is to deliver exceptional value, fast shipping, and a seamless experience every time you shop with us.
                    </p>
                </div>
            </section>

            <!-- Mission Section -->
            <section class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Our Mission</h2>
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 mb-4 md:mb-0 md:pr-6">
                            <p class="text-gray-700 leading-relaxed">
                                Our mission is simple: to empower our customers with choice, convenience, and confidence. We carefully curate our catalog to ensure every item meets our high standards, while offering discounts and deals that make shopping rewarding. Whether you’re upgrading your tech or refreshing your wardrobe, we’re here to make it happen with a smile.
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <svg class="w-48 h-48 text-[var(--primary-color)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Team Section -->
            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Meet Our Team</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ([
                            ['name' => 'Jane Doe', 'role' => 'Founder & CEO', 'bio' => 'Jane started this journey with a dream to redefine e-commerce.'],
                            ['name' => 'John Smith', 'role' => 'Head of Operations', 'bio' => 'John ensures every order ships on time and with care.'],
                            ['name' => 'Emily Brown', 'role' => 'Customer Happiness Lead', 'bio' => 'Emily’s here to make your shopping experience delightful.']
                        ] as $team)
                            <div class="text-center">
                                <div class="w-24 h-24 mx-auto mb-4 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-[var(--primary-color)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $team['name'] }}</h3>
                                <p class="text-sm text-[var(--primary-color)] mb-2">{{ $team['role'] }}</p>
                                <p class="text-gray-600 text-sm">{{ $team['bio'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>