<x-app-layout>
    <x-slot name="title">Welcome to {{ config('app.name', 'Your Store') }}</x-slot>


    <!-- Hero Section with Promotion -->
    <section class="relative bg-gradient-to-r from-[var(--primary-color)] to-[var(--primary-color-dark)] text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between">
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 animate-fade-in">
                    Spring Sale - Up to 50% Off!
                </h1>
                <p class="text-lg md:text-xl mb-6 animate-fade-in-delay">
                    Shop the latest products and enjoy exclusive discounts today.
                </p>
                <a href="{{ route('storefront.products.index') }}"
                   class="inline-block bg-white text-[var(--primary-color)] font-semibold px-8 py-3 rounded-full hover:bg-gray-100 transition-colors duration-300 shadow-lg animate-fade-in-delay-2">
                    Shop Now
                </a>
            </div>
            <div class="lg:w-1/2 mt-10 lg:mt-0 flex justify-center">
                <svg class="w-64 h-64 text-white transform hover:scale-105 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
        <div class="absolute bottom-0 w-full overflow-hidden leading-none">
            <svg class="w-full h-20" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V60C300,120 600,0 900,60 1200,120 1200,0 1200,0H0Z" fill="white" opacity="0.8"></path>
            </svg>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12 animate-fade-in">
                Shop by Category
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach (['Electronics', 'Fashion', 'Home & Living', 'Sports'] as $category)
                    <a href="{{ route('storefront.products.index', ['category' => strtolower($category)]) }}"
                       class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow duration-300 animate-fade-in-delay">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-[var(--primary-color)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $category }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12 animate-fade-in">
                Featured Products
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($featuredProducts ?? \App\Models\Product::where('featured', true)->take(4)->get() as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 animate-fade-in-delay">
                        <img src="{{ $product->images->first()->url ?? 'https://via.placeholder.com/300x200?text=' . $product->name }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 50) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[var(--primary-color)] font-bold text-xl">${{ number_format($product->getEffectivePrice(), 2) }}</span>
                                @if ($product->price > $product->getEffectivePrice())
                                    <span class="text-gray-500 line-through text-sm">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <form action="{{ route('storefront.cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-[var(--primary-color)] text-white py-2 rounded-md hover:bg-[var(--primary-color-dark)] transition-colors duration-200 {{ $product->isInStock() ? '' : 'opacity-50 cursor-not-allowed' }}"
                                        {{ $product->isInStock() ? '' : 'disabled' }}>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('storefront.products.index') }}"
                   class="inline-block text-[var(--primary-color)] font-semibold hover:underline">View All Products</a>
            </div>
        </div>
    </section>

<!-- Deals Section with Icons -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12 animate-fade-in">
            Hot Deals
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ([['title' => 'Limited Time Offer', 'discount' => '30% Off', 'icon' => 'clock'], ['title' => 'Bundle Sale', 'discount' => 'Buy 2, Get 1 Free', 'icon' => 'tag']] as $deal)
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row animate-fade-in-delay">
                    <div class="w-full md:w-1/2 h-64 flex items-center justify-center bg-gray-100">
                        @if ($deal['icon'] === 'clock')
                            <svg class="w-32 h-32 text-[var(--primary-color)] transform hover:scale-105 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2 2 0 0118 14V11a6 6 0 00-6-6 6 6 0 00-6 6v3a2 2 0 01-.595 1.595L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        @elseif ($deal['icon'] === 'tag')
                        <svg class="w-32 h-32 text-[var(--primary-color)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 11-4 0 2 2 0 014 0zm0 0V5.5A2.5 2.5 0 1114.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $deal['title'] }}</h3>
                        <p class="text-[var(--primary-color)] font-bold text-lg mb-4">{{ $deal['discount'] }}</p>
                        <a href="{{ route('storefront.products.index') }}"
                           class="inline-block bg-[var(--primary-color)] text-white px-6 py-2 rounded-md hover:bg-[var(--primary-color-dark)] transition-colors duration-200">
                            Shop Deal
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

    <!-- Custom CSS for Animations and Variables -->
    <style>
        :root {
            --primary-color: #008080;
            --primary-color-dark: #006666;
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        .animate-fade-in-delay {
            animation: fadeIn 1s ease-in-out 0.3s;
            animation-fill-mode: both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>