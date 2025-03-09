<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CatalogPriceRuleController;
use App\Http\Controllers\Admin\CartPriceRuleController;
use App\Http\Controllers\Admin\TieredPricingController;
use App\Http\Controllers\Admin\ConfigurationController;

// Public routes
// Route::get('/', function () {
//     return view('welcome');
// });

// Authentication routes (keep outside admin middleware)
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->middleware('verified')->name('home');
    Route::get('about', function () {
        return view('about-us');
    })->name('about');
    Route::get('Contact', function () {
        return view('contact-us');
    })->name('Contact');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/storefront/order/success/{order}', [CheckoutController::class, 'success'])->name('storefront.order.success');
});

// Multi-language prefix with admin routes
Route::group(['prefix' => config('app.enable_multi_language') ? '{locale}' : ''], function () {
    Route::group(['where' => ['locale' => '[a-zA-Z]{2}']], function () {
        Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
            Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
            Route::post('/products/bulk-delete', [App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
            Route::post('/products/{product}/images', [\App\Http\Controllers\Admin\ProductController::class, 'uploadImages'])->name('products.uploadImages');
            Route::get('/configurations/{storeId?}', [App\Http\Controllers\Admin\ConfigurationController::class, 'index'])->name('configurations.index');
            Route::patch('/configurations/{storeId?}', [App\Http\Controllers\Admin\ConfigurationController::class, 'update'])->name('configurations.update');
            Route::get('/configurations/storage-driver/edit', [App\Http\Controllers\Admin\ConfigurationController::class, 'editStorageDriver'])->name('configurations.editStorageDriver');
            Route::post('/configurations/storage-driver', [App\Http\Controllers\Admin\ConfigurationController::class, 'updateStorageDriver'])->name('configurations.updateStorageDriver');
            Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->except(['create', 'store', 'show']);
            Route::resource('users', App\Http\Controllers\Admin\UserController::class);
            Route::resource('stores', App\Http\Controllers\Admin\StoreController::class);
            Route::resource('inventories', \App\Http\Controllers\Admin\InventoryController::class)->except(['show', 'destroy']);
            Route::resource('attribute-keys', App\Http\Controllers\Admin\AttributeKeyController::class);
            Route::resource('warehouses', \App\Http\Controllers\Admin\WarehouseController::class)->except(['show', 'destroy']);
            Route::resource('shelves', \App\Http\Controllers\Admin\ShelfController::class)->except(['show', 'destroy']);
            Route::resource('inventories', \App\Http\Controllers\Admin\InventoryController::class)->except(['show', 'destroy']);
            Route::resource('categories', CategoryController::class);
            Route::resource('catalog-price-rules', CatalogPriceRuleController::class)->except(['show', 'destroy']);
            Route::resource('cart-price-rules', CartPriceRuleController::class)->except(['show', 'destroy']);
            Route::resource('tiered-pricing', TieredPricingController::class)->except(['show', 'destroy']);
        });
    });
});

// User address routes
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/addresses', [\App\Http\Controllers\User\AddressController::class, 'index'])->name('user.addresses.index');
    Route::get('/addresses/create', [\App\Http\Controllers\User\AddressController::class, 'create'])->name('user.addresses.create');
    Route::post('/addresses', [\App\Http\Controllers\User\AddressController::class, 'store'])->name('user.addresses.store');
    Route::get('/addresses/{type}/edit', [\App\Http\Controllers\User\AddressController::class, 'edit'])->name('user.addresses.edit');
    Route::put('/addresses/{type}', [\App\Http\Controllers\User\AddressController::class, 'update'])->name('user.addresses.update');
    Route::delete('/addresses/{type}', [\App\Http\Controllers\User\AddressController::class, 'destroy'])->name('user.addresses.destroy');
});

// Storefront routes
Route::group(['prefix' => config('app.enable_multi_language') ? '{locale}' : ''], function () {
    Route::get('/products', [StorefrontProductController::class, 'index'])->name('storefront.products.index');
    Route::get('/products/{product}', [StorefrontProductController::class, 'show'])->name('storefront.products.show');
    Route::match(['get', 'post'], '/cart', [CartController::class, 'index'])->name('storefront.cart.index'); // Updated to support GET and POST
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('storefront.cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('storefront.cart.update');
    Route::match(['get', 'post'], '/checkout', [CheckoutController::class, 'index'])->name('storefront.checkout.index');
});