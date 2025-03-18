<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <style>
            :root {
            --primary-color: #008080; /* Teal */
        }
        .bg-primary { background-color: var(--primary-color); }
        .hover\:bg-primary-dark:hover { background-color: #006666; }
        .focus\:ring-primary:focus { --tw-ring-color: var(--primary-color); }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">{{ config('app.name', 'Your Store') }}</h3>
                    <p class="text-sm">Your one-stop shop for quality products.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Shop</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('storefront.products.index') }}" class="hover:text-[var(--primary-color)] transition-colors duration-200">All Products</a></li>
                        <li><a href="#" class="hover:text-[var(--primary-color)] transition-colors duration-200">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-[var(--primary-color)] transition-colors duration-200">Best Sellers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-[var(--primary-color)] transition-colors duration-200">Contact Us</a></li>
                        <li><a href="#" class="hover:text-[var(--primary-color)] transition-colors duration-200">FAQs</a></li>
                        <li><a href="#" class="hover:text-[var(--primary-color)] transition-colors duration-200">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-[var(--primary-color)] transition-colors duration-200">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.3 4.3 0 001.88-2.38 8.6 8.6 0 01-2.72 1.05 4.3 4.3 0 00-7.32 3.92A12.2 12.2 0 011.67 5.59a4.3 4.3 0 001.33 5.74c-.65-.02-1.27-.2-1.8-.5v.05a4.3 4.3 0 003.44 4.2 4.3 4.3 0 01-1.94.07 4.3 4.3 0 004 2.98A8.6 8.6 0 010 20.56a12.2 12.2 0 006.6 1.94c7.92 0 12.24-6.56 12.24-12.24 0-.19 0-.38-.01-.57A8.7 8.7 0 0022.46 6z"/></svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-[var(--primary-color)] transition-colors duration-200">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7v-3h3V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.84-.98 8.44-4.99 8.44-9.95z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 text-center text-sm">
                © {{ date('Y') }} {{ config('app.name', 'Your Store') }}. All rights reserved.
                <div class="mt-2 text-xs text-gray-500 opacity-75">
                    Powered by <a href="https://businesscart.ai" target="_blank" class="hover:text-[var(--primary-color)] transition-colors duration-200">BusinessCart</a>
                </div>
            </div>
        </div>
    </footer>
    </body>
</html>
