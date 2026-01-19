<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

// Use MySQL (default)
config(['database.default' => 'mysql']);

// Simulate a user
$user = \App\Models\User::first();
if ($user) {
    Auth::login($user);
    echo "Logged in as user ID: " . $user->id . "\n";
}

$cart = Cart::getOrCreateCart();
$cart->load('items.product');

echo "Cart ID: " . $cart->id . "\n";
echo "Items count: " . $cart->items->count() . "\n";
echo "Subtotal from attribute: " . $cart->subtotal . "\n";
echo "Subtotal from sum: " . $cart->items->sum('total_price') . "\n";

foreach ($cart->items as $item) {
    echo "Item: {$item->item_name}, Qty: {$item->quantity}, Unit: {$item->unit_price}, Total: {$item->total_price}\n";
}
