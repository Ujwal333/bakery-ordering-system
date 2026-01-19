<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "Debugging Cart & Prices...\n\n";

// 1. Check Products Prices
echo "Checking first 5 products:\n";
$products = Product::take(5)->get();
foreach ($products as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | Price: {$p->price}\n";
}
echo "\n";

// 2. Check All Cart Items in DB
echo "Checking Cart Items:\n";
$items = CartItem::all();
if ($items->isEmpty()) {
    echo "No items in ANY cart.\n";
} else {
    foreach ($items as $item) {
        echo "CartID: {$item->cart_id} | ProductID: {$item->product_id} | Qty: {$item->quantity} | UnitPrice: {$item->unit_price} | TotalPrice: {$item->total_price}\n";
    }
}

// 3. Check Carts
echo "\nChecking Carts:\n";
$carts = Cart::with('items')->get();
foreach ($carts as $c) {
    $sum = $c->items->sum('total_price');
    echo "CartID: {$c->id} | UserID: {$c->user_id} | SessionID: {$c->session_id} | Calculated Sum: {$sum}\n";
}
