<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;

echo "System Audit...\n";

// 1. Check Payment Table
$p = new Payment();
echo "Payment Model Table: " . $p->getTable() . "\n";
if ($p->getTable() === 'payment_logs' && Schema::hasTable('payment_logs')) {
    echo "✅ Payment Model maps to 'payment_logs' correctly.\n";
} else {
    echo "❌ Payment Model mismatch!\n";
}

// 2. Check Order Columns
if (Schema::hasColumn('orders', 'latitude') && Schema::hasColumn('orders', 'longitude')) {
    echo "✅ Order table has Geolocation columns.\n";
} else {
    echo "❌ Order table missing Geolocation columns!\n";
}

// 3. Check Order Fillables
$o = new Order();
if (in_array('latitude', $o->getFillable()) && in_array('payment_status', $o->getFillable())) {
    echo "✅ Order Model Fillables correct.\n";
} else {
    echo "❌ Order Model Fillables details missing.\n";
}

echo "Audit Complete.\n";
