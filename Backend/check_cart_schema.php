<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.database' => __DIR__ . '/bakery_ordering_system']);

echo "Checking Cart Items Table Schema...\n";

try {
    $results = DB::select("PRAGMA table_info(cart_items)");
    foreach ($results as $column) {
        echo "Column: " . $column->name . "\n";
        echo "  - Type: " . $column->type . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
