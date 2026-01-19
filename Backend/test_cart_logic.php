<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.database' => __DIR__ . '/bakery_ordering_system']);

echo "Testing Cart Subtotal Calculation...\n";

try {
    DB::beginTransaction();

    // 1. Setup User
    $user = User::first();
    if (!$user) {
        $user = User::factory()->create();
    }
    Auth::login($user);
    echo "User ID: " . $user->id . "\n";

    // 2. Setup Product
    $product = Product::first();
    if (!$product) {
        $product = Product::create([
            'name' => 'Test Cake',
            'slug' => 'test-cake-' . time(),
            'price' => 500,
            'description' => 'Test',
            'category_id' => 1,
            'brand_id' => 1, 
        ]);
    }
    echo "Product ID: " . $product->id . ", Price: " . $product->price . "\n";

    // 3. Add to Cart (Directly, mirroring Controller logic)
    $cart = Cart::getOrCreateCart();
    echo "Cart ID: " . $cart->id . "\n";

    // Clear existing
    $cart->clear();

    // Add Item
    CartItem::create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'item_name' => $product->name,
        'quantity' => 2,
        'unit_price' => $product->price,
        'total_price' => $product->price * 2,
    ]);

    // 4. Check Subtotal
    $cart->refresh(); // Reload relation
    $cart->load('items');

    echo "Cart Items Count: " . $cart->items->count() . "\n";
    foreach ($cart->items as $item) {
        echo " - Item: {$item->item_name}, Qty: {$item->quantity}, Total: {$item->total_price}\n";
    }

    $subtotal = $cart->subtotal;
    echo "Calculated Subtotal: " . $subtotal . "\n";

    $expected = $product->price * 2;
    if ($subtotal == $expected) {
        echo "✅ Subtotal calculation is CORRECT.\n";
    } else {
        echo "❌ Subtotal calculation is INCORRECT. Expected $expected, got $subtotal\n";
    }

    DB::rollBack();

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
