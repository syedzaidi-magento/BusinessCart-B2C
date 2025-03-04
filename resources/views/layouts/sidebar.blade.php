<aside class="fixed inset-y-0 left-0 w-64 bg-gray-200 text-gray-800 transform transition-transform duration-300 ease-in-out {{ $sidebarOpen ? 'translate-x-0' : '-translate-x-full' }} md:translate-x-0 z-20">
    <div class="p-4 flex items-center space-x-2 border-b border-gray-300">
        <div>{!! $logoSvg !!}</div>
        <div class="text-xl font-bold">Admin Panel</div>
    </div>
    <nav class="mt-4">
        <ul class="space-y-1">
            <li><a href="{{ route('admin.dashboard') }}" class="block p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'hover:bg-gray-300' }} font-medium">Dashboard</a></li>
            <li><a href="{{ route('admin.configurations') }}" class="block p-3 {{ request()->routeIs('admin.configurations') ? 'bg-primary text-white' : 'hover:bg-gray-300' }} font-medium">Configurations</a></li>
            <li><a href="{{ route('admin.products') }}" class="block p-3 {{ request()->routeIs('admin.products') ? 'bg-primary text-white' : 'hover:bg-gray-300' }} font-medium">Products</a></li>
            <li><a href="{{ route('admin.orders') }}" class="block p-3 {{ request()->routeIs('admin.orders') ? 'bg-primary text-white' : 'hover:bg-gray-300' }} font-medium">Orders</a></li>
            <li><a href="{{ route('admin.users') }}" class="block p-3 {{ request()->routeIs('admin.users') ? 'bg-primary text-white' : 'hover:bg-gray-300' }} font-medium">Users</a></li>
        </ul>
    </nav>
</aside>

<!-- Overlay for mobile -->
@if ($sidebarOpen)
    <div wire:click="toggleSidebar" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-10 md:hidden"></div>
@endif