<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CustomCakeController;
use App\Http\Controllers\CartController;

// Serve HTML pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/menu/{category?}', [PageController::class, 'browseMenu'])->name('browse-menu');
Route::get('/custom-cake', [PageController::class, 'customCake'])->name('custom-cake');
Route::post('/custom-cakes/submit', [CustomCakeController::class, 'submit'])->name('custom-cakes.submit')->middleware('auth');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::get('/order-tracking', [PageController::class, 'orderTracking'])->name('order-tracking');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/admin/login', [PageController::class, 'login'])->name('admin.login');

// Cart Routes (Session-based for guests, DB for auth)
Route::group(['prefix' => 'cart'], function () {
    Route::get('/view', [CartController::class, 'index'])->name('cart.data');
    Route::get('/count', [CartController::class, 'getCount'])->name('cart.count');
    Route::post('/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::post('/custom-cake', [CartController::class, 'addCustomCake'])->name('cart.custom-cake');
    Route::put('/item/{id}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/item/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
});

// Payment Routes (Protcted by auth)
Route::middleware('auth')->group(function () {
    Route::get('/payment/khalti/initiate/{order}', [\App\Http\Controllers\PaymentController::class, 'payWithKhalti'])->name('payment.khalti');
    Route::get('/payment/khalti/verify', [\App\Http\Controllers\PaymentController::class, 'verifyKhalti'])->name('payment.khalti.verify');
    Route::get('/payment/esewa/initiate/{order}', [\App\Http\Controllers\PaymentController::class, 'payWithEsewa'])->name('payment.esewa');
    Route::get('/payment/esewa/verify/{id}', [\App\Http\Controllers\PaymentController::class, 'verifyEsewa'])->name('payment.esewa.verify');
});

// Admin Routes (Protected by auth and admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard (Placeholder)
    Route::get('/dashboard', function () {
        return view('admin.layout'); // Just showing layout for now as dashboard
    })->name('dashboard');

    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::patch('categories/{id}/toggle', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle');

    // Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::patch('products/{id}/toggle', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle');

    // Orders
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    // For manual status updates
    Route::patch('orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{id}/payment-status', [\App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');

    // Custom Cakes
    Route::get('custom-cakes', [\App\Http\Controllers\Admin\CustomCakeController::class, 'index'])->name('custom-cakes.index');
    Route::get('custom-cakes/{id}', [\App\Http\Controllers\Admin\CustomCakeController::class, 'show'])->name('custom-cakes.show');
    Route::patch('custom-cakes/{id}/status', [\App\Http\Controllers\Admin\CustomCakeController::class, 'updateStatus'])->name('custom-cakes.update-status');

    // Events
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
});

// Catch all other frontend routes
Route::get('/{any}', [PageController::class, 'home'])->where('any', '.*');
