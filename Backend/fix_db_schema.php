<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Current Status Column Type:\n";
    $result = DB::select("SHOW COLUMNS FROM orders WHERE Field = 'status'");
    print_r($result[0]->Type);
    echo "\n\n";

    echo "Attempting to fix...\n";
    DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','preparing','ready','with_logistic','out_for_delivery','delivered','cancelled') DEFAULT 'pending'");
    DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending','paid','completed','failed','refunded') DEFAULT 'pending'");
    
    echo "Fix applied. New Status Column Type:\n";
    $result = DB::select("SHOW COLUMNS FROM orders WHERE Field = 'status'");
    print_r($result[0]->Type);
    echo "\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
