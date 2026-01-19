<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use Carbon\Carbon;

function test($name, $callback) {
    echo "Testing $name... ";
    try {
        $callback();
        echo "OK\n";
    } catch (\Exception $e) {
        echo "FAILED: " . $e->getMessage() . "\n";
    }
}

test('User count', fn() => User::count());
test('Order count', fn() => Order::count());
test('Today orders', fn() => Order::whereDate('created_at', Carbon::today())->count());
test('Revenue', fn() => Payment::where('status', 'completed')->sum('amount'));
test('Recent orders', fn() => Order::with('user', 'payments')->orderBy('created_at', 'desc')->limit(10)->get());
test('Top products', fn() => Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->limit(5)->get());

test('Orders by status', function() {
    Order::select('status')
            ->groupBy('status')
            ->selectRaw('count(*) as total')
            ->get();
});

test('Payment methods', function() {
    Payment::where('status', 'completed')
            ->select('provider')
            ->groupBy('provider')
            ->selectRaw('count(*) as total, sum(amount) as revenue')
            ->get();
});

test('Additional models', function() {
    \App\Models\Brand::count();
    \App\Models\Subscriber::count();
    // \App\Models\ContactQuery::count(); // Might not exist
    // \App\Models\Testimonial::count(); // Might not exist
    \App\Models\Admin::count();
});
