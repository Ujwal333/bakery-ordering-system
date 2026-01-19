<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CustomCakeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;

// Public Submission Routes (API-like)
Route::post('/api/inquiries', [SupportController::class, 'submitInquiry']);
Route::post('/api/reviews', [SupportController::class, 'submitReview'])->middleware('auth');
Route::post('/api/subscribe', [SupportController::class, 'subscribe']);

// Serve HTML pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/menu/{category?}', [PageController::class, 'browseMenu'])->name('browse-menu');
Route::get('/custom-cake', [PageController::class, 'customCake'])->name('custom-cake');
Route::post('/custom-cakes/submit', [CustomCakeController::class, 'submit'])->name('custom-cakes.submit')->middleware('auth');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

// Checkout and Order Tracking (Protected by auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
    Route::get('/order-tracking', [PageController::class, 'orderTracking'])->name('order-tracking');
    Route::get('/order-confirmation', [PageController::class, 'orderConfirmation'])->name('order-confirmation');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [PageController::class, 'orders'])->name('orders.user');
    Route::get('/wishlist', [PageController::class, 'wishlist'])->name('wishlist');
    Route::get('/addresses', [PageController::class, 'addresses'])->name('addresses');
    Route::get('/orders/track', [OrderController::class, 'track'])->name('orders.track');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    
    // User Profile & Settings (IG-style)
    Route::get('/profile/settings', [ProfileController::class, 'getSettings']);
    Route::post('/wishlist/toggle', [ProfileController::class, 'toggleSaved']);
    Route::post('/payment/initiate', [\App\Http\Controllers\PaymentController::class, 'initiate'])->name('payment.initiate');
});

Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/help', function() { return redirect('/about#help-section'); });
// Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/features', function() { return redirect('/about#features'); });
Route::get('/gallery', function() { return redirect('/about#gallery'); });
Route::get('/events', [PageController::class, 'events'])->name('events');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function() { return redirect('/'); });

// Forgot Password Routes
Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password/send-otp', [\App\Http\Controllers\ForgotPasswordController::class, 'sendOtp']);
Route::post('/forgot-password/verify-otp', [\App\Http\Controllers\ForgotPasswordController::class, 'verifyOtp']);
Route::post('/forgot-password/reset', [\App\Http\Controllers\ForgotPasswordController::class, 'resetPassword']);

// Google OAuth Routes
Route::get('/auth/google', [\App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback']);

Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Table Management API
Route::get('/api/tables/available', [\App\Http\Controllers\Api\TableController::class, 'getAvailableTables']);
Route::get('/api/tables/{tableNumber}/status', [\App\Http\Controllers\Api\TableController::class, 'getTableStatus']);

// Careers
Route::get('/careers', [\App\Http\Controllers\JobController::class, 'index'])->name('careers');
Route::post('/job-applications', [\App\Http\Controllers\JobController::class, 'apply'])->name('jobs.apply');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\LoginController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', function() { return redirect()->route('admin.login'); });

    // Protected Admin Routes
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Catalog & Sales
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
        Route::resource('custom-cakes', \App\Http\Controllers\Admin\CustomCakeController::class);
        Route::resource('cake-options', \App\Http\Controllers\Admin\CakeOptionController::class);
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/orders/{order}/status', function($order) { return redirect()->route('admin.orders.show', $order); }); // Fallback for refresh
        Route::get('/orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('orders.invoice');
        Route::patch('/custom-cakes/{customCake}/status', [\App\Http\Controllers\Admin\CustomCakeController::class, 'updateStatus'])->name('custom-cakes.update-status');
        
        // Dine-In Management
        Route::get('/dinein', [\App\Http\Controllers\Admin\TableManagementController::class, 'index'])->name('dinein.index');
        Route::patch('/dinein/{table}/update-status', [\App\Http\Controllers\Admin\TableManagementController::class, 'updateStatus'])->name('dinein.update-status');
        Route::post('/dinein/{table}/free', [\App\Http\Controllers\Admin\TableManagementController::class, 'free'])->name('dinein.free');

        // Careers Management
        Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
        Route::get('/job-applications', [\App\Http\Controllers\Admin\JobController::class, 'applications'])->name('jobs.applications');
        Route::patch('/job-applications/{application}/status', [\App\Http\Controllers\Admin\JobController::class, 'updateApplicationStatus'])->name('jobs.update-application-status');

        // Support & CRM
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::patch('/queries/{query}/status', [\App\Http\Controllers\Admin\ContactQueryController::class, 'updateStatus'])->name('queries.update-status');
        Route::resource('queries', \App\Http\Controllers\Admin\ContactQueryController::class);
        Route::patch('/testimonials/{testimonial}/toggle-status', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleStatus'])->name('testimonials.toggle-status');
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class);
        
        // Content & System
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
        Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::patch('/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('payments.update');
        
        // Logistics
        Route::resource('logistics', \App\Http\Controllers\Admin\LogisticController::class);
        Route::post('/orders/{order}/handover', [\App\Http\Controllers\Admin\LogisticController::class, 'handover'])->name('orders.handover');
        
        // Payment Methods Management
        Route::resource('payment-methods', \App\Http\Controllers\Admin\PaymentMethodController::class);
        Route::patch('/payment-methods/{paymentMethod}/toggle-status', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'toggleStatus'])->name('payment-methods.toggle-status');
        
        // Gallery Management
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
        Route::patch('/gallery/{gallery}/toggle-featured', [\App\Http\Controllers\Admin\GalleryController::class, 'toggleFeatured'])->name('gallery.toggle-featured');

        // Features Management
        Route::resource('features', \App\Http\Controllers\Admin\FeatureController::class);
        Route::patch('/features/{feature}/toggle-active', [\App\Http\Controllers\Admin\FeatureController::class, 'toggleActive'])->name('features.toggle-active');

        // Help Content Management
        Route::resource('help-contents', \App\Http\Controllers\Admin\HelpContentController::class);
        Route::patch('/help-contents/{helpContent}/toggle-active', [\App\Http\Controllers\Admin\HelpContentController::class, 'toggleActive'])->name('help-contents.toggle-active');

        // Page Content (About Us, etc)
        Route::get('page-contents', [\App\Http\Controllers\Admin\PageContentController::class, 'index'])->name('page-contents.index');
        Route::put('page-contents/{pageContent}', [\App\Http\Controllers\Admin\PageContentController::class, 'update'])->name('page-contents.update');

        // Settings (All Admins)
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Super Admin Restricted
        Route::middleware(['admin.role:superadmin'])->group(function () {
             Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);
             Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
             
             // Emergency Fix Route for User
             Route::get('/fix-db-content', function() {
                 // 1. Seed Page Contents
                 $contents = [
                     ['page_key' => 'home', 'section_key' => 'hero', 'title' => 'Artisan Bakery Crafted with Love', 'content' => 'Discover our handcrafted pastries, cakes, and breads made with premium ingredients'],
                     ['page_key' => 'about', 'section_key' => 'hero', 'title' => 'About Us', 'content' => null],
                     ['page_key' => 'about', 'section_key' => 'main', 'title' => 'About Cinnamon Bakery', 'content' => "Welcome to Cinnamon Bakery! Established in 2022, we've been crafting delicious treats with love."],
                     ['page_key' => 'about', 'section_key' => 'quote', 'title' => 'Our Mission', 'content' => 'Sweet moments for everyone.'],
                     ['page_key' => 'features', 'section_key' => 'intro', 'title' => 'Our Sweet Features', 'content' => 'Discover all the ways we make your experience with Cinnamon Bakery delightful, convenient, and memorable.'],
                     ['page_key' => 'features', 'section_key' => 'gallery', 'title' => 'Cinnamon Gallery', 'content' => 'Explore our collection of signature creations and customer favorites.'],
                 ];
                 foreach($contents as $c) {
                     \App\Models\PageContent::firstOrCreate(
                         ['page_key' => $c['page_key'], 'section_key' => $c['section_key']],
                         ['title' => $c['title'], 'content' => $c['content']]
                     );
                 }

                 // 2. Seed Settings
                 $settings = [
                     'bakery_name' => 'Cinnamon Bakery',
                     'footer_description' => 'Artisan bakery crafting delicious treats since 2022. Quality ingredients, traditional methods, modern flavors.',
                     'contact_address' => 'Sano Bharayang, Kathmandu, Nepal',
                     'contact_email' => 'info@cinnamonbakery.com',
                     'contact_phone' => '+977 9769349551',
                     'contact_hours' => 'Open Daily: 8AM - 8PM',
                     'newsletter_text' => 'Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.',
                     'delivery_charge' => '100',
                     'min_order_free_delivery' => '2000',
                     'tax_percentage' => '13'
                 ];
                 foreach($settings as $key => $value) {
                     \App\Models\Setting::firstOrCreate(['key' => $key], ['value' => $value]);
                 }

                 return redirect()->route('admin.page-contents.index')->with('success', 'Database content has been fixed! You can now edit everything.');
             })->name('fix.content');
        });
    });
});

// Cart Routes - PROTECTED: Require login to add to cart
Route::group(['prefix' => 'cart', 'middleware' => ['json.response', 'auth']], function () {
    Route::post('/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::post('/custom-cake', [CartController::class, 'addCustomCake'])->name('cart.custom-cake');
    Route::put('/item/{id}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/item/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
});

// Cart View Routes - Allow viewing cart without login
Route::get('/cart/view', [CartController::class, 'index'])->name('cart.data');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

// Order Tracking Routes
Route::get('/track/{order}', [\App\Http\Controllers\Web\OrderTrackingController::class, 'show'])->name('order.track');
Route::get('/api/order-status/{order}', [\App\Http\Controllers\Web\OrderTrackingController::class, 'getStatus'])->name('api.order.status');

// Chatbot API Routes
Route::prefix('chatbot')->group(function () {
    Route::get('/init', [\App\Http\Controllers\ChatbotController::class, 'getInitData'])->name('chatbot.init');
    Route::get('/products', [\App\Http\Controllers\ChatbotController::class, 'getProducts'])->name('chatbot.products');
    Route::get('/custom-steps', [\App\Http\Controllers\ChatbotController::class, 'getCustomCakeSteps'])->name('chatbot.custom-steps');
});

// Payment Callback Routes
Route::get('/payment/esewa/success', [\App\Http\Controllers\PaymentController::class, 'esewaSuccess'])->name('payment.esewa.success');
Route::get('/payment/esewa/failure', [\App\Http\Controllers\PaymentController::class, 'esewaFailure'])->name('payment.esewa.failure');
Route::get('/payment/khalti/callback', [\App\Http\Controllers\PaymentController::class, 'khaltiCallback'])->name('payment.khalti.callback');

// Catch-all route
Route::get('/{any}', [PageController::class, 'home'])->where('any', '.*');
