<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomCakeController;
use App\Http\Controllers\HomeController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/popular', [ProductController::class, 'popular']);
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/specials', [ProductController::class, 'specials']);
Route::get('/products/flavors', [ProductController::class, 'flavors']);
Route::get('/products/sizes', [ProductController::class, 'sizes']);
Route::get('/products/cake-options', [ProductController::class, 'cakeOptions']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products/id/{id}', [ProductController::class, 'getById']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Cart (available without auth for guests)
Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/count', [CartController::class, 'count']);
Route::post('/cart/add', [CartController::class, 'addItem']);
Route::post('/cart/custom-cake', [CartController::class, 'addCustomCake']);
Route::put('/cart/item/{id}', [CartController::class, 'updateItem']);
Route::delete('/cart/item/{id}', [CartController::class, 'removeItem']);
Route::delete('/cart/clear', [CartController::class, 'clear']);

// Order tracking (public)
Route::post('/orders/track', [OrderController::class, 'track']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::post('/user/change-password', [AuthController::class, 'changePassword']);

    // Orders
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/my', [OrderController::class, 'myOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);

    // Custom cakes
    Route::post('/custom-cakes', [CustomCakeController::class, 'store']);
    Route::get('/custom-cakes', [CustomCakeController::class, 'index']);
    Route::get('/custom-cakes/{id}', [CustomCakeController::class, 'show']);
    Route::put('/custom-cakes/{id}', [CustomCakeController::class, 'update']);
    Route::delete('/custom-cakes/{id}', [CustomCakeController::class, 'destroy']);
    Route::post('/custom-cakes/calculate-price', [CustomCakeController::class, 'calculatePrice']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/orders', [OrderController::class, 'index']);
        Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);
    });
});

// Home page data
Route::get('/home-data', [HomeController::class, 'index']);
