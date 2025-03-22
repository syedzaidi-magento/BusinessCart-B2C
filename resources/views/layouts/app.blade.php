<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <style>
            :root {
                --primary-color: #008080; /* Teal */
                --primary-color-dark: #006666; /* Darker Teal for hover */
            }
            .bg-primary { background-color: var(--primary-color); }
            .hover\:bg-primary-dark:hover { background-color: var(--primary-color-dark); }
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

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4">{{ config('app.name', 'Your Store') }}</h3>
                        <p class="text-sm">Your ultimate destination for top-quality products, handpicked to elevate your everyday life. Shop with confidence and discover the difference quality makes.</p>
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
                            <li><a href="{{ route('contact') }}" class="hover:text-[var(--primary-color)] transition-colors duration-200">Contact Us</a></li>
                            <li><a href="{{ route('faqs') }}" class="hover:text-[var(--primary-color)] transition-colors duration-200">FAQs</a></li>
                            <li><a href="#" class="hover:text-[var(--primary-color)] transition-colors duration-200">Returns</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4">Follow Us</h3>
                        <div class="flex space-x-4">
                            <!-- Twitter -->
                            <a href="#" class="text-gray-300 hover:text-[var(--primary-color)] transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.3 4.3 0 001.88-2.38 8.6 8.6 0 01-2.72 1.05 4.3 4.3 0 00-7.32 3.92A12.2 12.2 0 011.67 5.59a4.3 4.3 0 001.33 5.74c-.65-.02-1.27-.2-1.8-.5v.05a4.3 4.3 0 003.44 4.2 4.3 4.3 0 01-1.94.07 4.3 4.3 0 004 2.98A8.6 8.6 0 010 20.56a12.2 12.2 0 006.6 1.94c7.92 0 12.24-6.56 12.24-12.24 0-.19 0-.38-.01-.57A8.7 8.7 0 0022.46 6z"/></svg>
                            </a>
                            <!-- Facebook -->
                            <a href="#" class="text-gray-300 hover:text-[var(--primary-color)] transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7v-3h3V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.84-.98 8.44-4.99 8.44-9.95z"/></svg>
                            </a>
                            <!-- Instagram -->
                            <a href="#" class="text-gray-300 hover:text-[var(--primary-color)] transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.84.07 1.26.06 2.12.26 2.88.56.78.3 1.44.7 2.1 1.36s1.06 1.32 1.36 2.1c.3.76.5 1.62.56 2.88.06 1.26.07 1.64.07 4.84s-.01 3.58-.07 4.84c-.06 1.26-.26 2.12-.56 2.88-.3.78-.7 1.44-1.36 2.1s-1.32 1.06-2.1 1.36c-.76.3-1.62.5-2.88.56-1.26.06-1.64.07-4.84.07s-3.58-.01-4.84-.07c-1.26-.06-2.12-.26-2.88-.56-.78-.3-1.44-.7-2.1-1.36S2.7 20.1 2.4 19.32c-.3-.76-.5-1.62-.56-2.88C2.78 15.18 2.77 14.8 2.77 11.6s.01-3.58.07-4.84c.06-1.26.26-2.12.56-2.88.3-.78.7-1.44 1.36-2.1S6.9 2.7 7.68 2.4c.76-.3 1.62-.5 2.88-.56C8.3 2.78 7.92 2.77 4.72 2.77zm0 2.82c-3.14 0-3.5.01-4.74.07-.92.04-1.42.2-1.76.32-.44.16-.76.38-1.1.72-.34.34-.56.66-.72 1.1-.12.34-.28.84-.32 1.76-.06 1.24-.07 1.6-.07 4.74s.01 3.5.07 4.74c.04.92.2 1.42.32 1.76.16.44.38.76.72 1.1.34.34.66.56 1.1.72.34.12.84.28 1.76.32 1.24.06 1.6.07 4.74.07s3.5-.01 4.74-.07c.92-.04 1.42-.2 1.76-.32.44-.16.76-.38 1.1-.72.34-.34.56-.66.72-1.1.12-.34.28-.84.32-1.76.06-1.24.07-1.6.07-4.74s-.01-3.5-.07-4.74c-.04-.92-.2-1.42-.32-1.76-.16-.44-.38-.76-.72-1.1-.34-.34-.66-.56-1.1-.72-.34-.12-.84-.28-1.76-.32-1.24-.06-1.6-.07-4.74-.07zm0 2.66c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 8.34c-1.86 0-3.34-1.48-3.34-3.34s1.48-3.34 3.34-3.34 3.34 1.48 3.34 3.34-1.48 3.34-3.34 3.34zm5.34-9c-.66 0-1.2.54-1.2 1.2s.54 1.2 1.2 1.2 1.2-.54 1.2-1.2-.54-1.2-1.2-1.2z"/></svg>
                            </a>
                            <!-- LinkedIn -->
                            <a href="#" class="text-gray-300 hover:text-[var(--primary-color)] transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45H16.9v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.13 1.45-2.13 2.94v5.67H9.35V9.01h3.41v1.56h.05c.48-.91 1.65-1.87 3.39-1.87 3.63 0 4.3 2.39 4.3 5.5v6.25zM5.34 7.45c-1.11 0-2-.9-2-2s.89-2 2-2 2 .9 2 2-.89 2-2 2zm1.78 13H3.56V9.01h3.56v11.44zM22 2H2C.9 2 0 2.9 0 4v16c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                            </a>
                        </div>
                        <!-- Trusted Icons -->
                        <div class="mt-8 flex space-x-4 justify-left">
                            <h3 class="text-lg font-semibold text-white mb-4">Trusted By</h3>
                            <!-- Visa -->
                            <svg class="h-6 w-8 text-gray-300" fill="currentColor" viewBox="0 0 32 20"><path d="M12.7 2.2l-3.8 15.6H6.2L2.4 2.2H0v-.2h5.6l2.8 11.8L11 2.2h1.7zm8.5 0l-2.8 15.6h-2.4l2.8-15.6h2.4zm8.5 0v.2h-2.6l-3.6 12.6-2-10.2-2.6 10.2-1-5.2-1.4 5.2h-2.2l2.8-15.6h2.8l1.8 9.8 2-9.8h2.4l2.8 13 1-3.2z"/></svg>
                            <!-- Mastercard -->
                            <svg class="h-6 w-8 text-gray-300" fill="currentColor" viewBox="0 0 32 20"><path d="M11.8 2c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 13.8c-3.2 0-5.8-2.6-5.8-5.8S8.6 4.2 11.8 4.2s5.8 2.6 5.8 5.8-2.6 5.8-5.8 5.8zm8.4-13.8c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 13.8c-3.2 0-5.8-2.6-5.8-5.8s2.6-5.8 5.8-5.8 5.8 2.6 5.8 5.8-2.6 5.8-5.8 5.8z"/></svg>
                            <!-- PayPal -->
                            <svg class="h-6 w-8 text-gray-300" fill="currentColor" viewBox="0 0 32 20"><path d="M8.4 2h6c3 0 5.2 1.4 6 4.2.6 2-.2 3.8-2 4.8h-2.6c1-.6 1.6-1.6 1.4-2.8-.2-1.6-1.6-2.6-3.4-2.6h-5.2c-.6 0-1 .4-1 1v1.2c0 .6.4 1 1 1h6.6c1 0 1.8.8 1.8 1.8s-.8 1.8-1.8 1.8H9.4c-1.8 0-3.4-1.4-3.4-3.2V5.2C6 3.4 7.4 2 9.4 2h-.2zm14 6c1.8 0 3.4 1.4 3.4 3.2v3.6c0 1.8-1.4 3.2-3.4 3.2h-6c-3 0-5.2-1.4-6-4.2-.6-2 .2-3.8 2-4.8h2.6c-1 .6-1.6 1.6-1.4 2.8.2 1.6 1.6 2.6 3.4 2.6h5.2c.6 0 1-.4 1-1v-1.2c0-.6-.4-1-1-1h-6.6c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8h9.2z"/></svg>
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
        </div>
    </body>
</html>