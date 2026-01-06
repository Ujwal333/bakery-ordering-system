<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Serve HTML pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/browse-menu', [PageController::class, 'browseMenu'])->name('browse-menu');
Route::get('/custom-cake', [PageController::class, 'customCake'])->name('custom-cake');
Route::get('/order-tracking', [PageController::class, 'orderTracking'])->name('order-tracking');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');

// Catch all other frontend routes
Route::get('/{any}', [PageController::class, 'home'])->where('any', '.*');
