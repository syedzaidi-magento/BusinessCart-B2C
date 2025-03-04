<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Storefront') - BusinessCart</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --primary-color: #008080; /* Teal */
        }
        .bg-primary { background-color: var(--primary-color); }
        .hover\:bg-primary-dark:hover { background-color: #006666; }
        .focus\:ring-primary:focus { --tw-ring-color: var(--primary-color); }
        html, body {
            height: 100%;
            margin: 0;
        }
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
            width: 100%;
        }
        footer {
            flex-shrink: 0;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        <header class="bg-white shadow-md sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    @include('partials.admin-logo')
                    <h1 class="text-2xl font-bold text-gray-900">BusinessCart</h1>
                </div>
                <nav class="flex space-x-6">
                    <a href="{{ route('storefront.products.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-200">Shop</a>
                    <a href="{{ route('storefront.cart.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-200">Cart ({{ session('cart', []) ? count(session('cart')) : 0 }})</a>
                </nav>
            </div>
        </header>
        <main class="px-4 py-8">
            @if (session('success'))
                <div class="max-w-7xl mx-auto mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="max-w-7xl mx-auto mb-6 p-4 rounded-lg bg-red-50 text-red-700 border-l-4 border-red-500">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>© {{ date('Y') }} BusinessCart. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>