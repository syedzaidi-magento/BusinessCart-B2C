<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS -->
    <style>
        :root {
            --primary-color: #008080; /* Teal, consistent with your earlier setup */
        }
        .bg-primary { background-color: var(--primary-color); }
        .hover\:bg-primary-dark:hover { background-color: #006666; }
        .focus\:ring-primary:focus { --tw-ring-color: var(--primary-color); }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transform transition-all duration-300 ease-in-out md:translate-x-0 z-20">
            <div class="p-4 flex items-center space-x-2 border-b border-gray-700">
                @include('partials.admin-logo')
                <div class="text-xl font-bold">BusinessCart</div>
            </div>
            <nav class="mt-4 px-2">
                <ul class="space-y-2">
                <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <span>Products</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-7 5h7"></path>
                    </svg>
                    <span>Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.inventories.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.inventories.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0H4"></path>
                    </svg>
                    <span>Inventory</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.stores.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.stores.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9-2H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"></path>
                    </svg>
                    <span>Stores</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.catalog-price-rules.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.catalog-price-rules.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z"></path>
                    </svg>
                    <span>Catalog Price Rules</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.cart-price-rules.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.cart-price-rules.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-2 13H5L3 3zm4 18a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <span>Cart Price Rules</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tiered-pricing.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.tiered-pricing.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Tiered Pricing</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.attribute-keys.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.attribute-keys.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    <span>Custom Attributes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.warehouses.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.warehouses.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10"></path>
                    </svg>
                    <span>Warehouses</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.shelves.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.shelves.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span>Shelves</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.configurations.index') }}" class="flex items-center space-x-2 p-3 rounded-lg {{ request()->routeIs('admin.configurations.*') ? 'bg-teal-500 text-white' : 'hover:bg-gray-700' }} transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37 1 .608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Configurations</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-10 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <button id="toggle-sidebar" class="md:hidden text-gray-700 hover:text-gray-900 focus:outline-none transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-900">@yield('page-title')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Main Area -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('toggle-sidebar').addEventListener('click', function () {
            document.querySelector('aside').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>