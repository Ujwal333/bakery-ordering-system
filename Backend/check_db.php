<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select('SHOW TABLES');
    echo "Database tables:\n";
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "- $tableName\n";
    }

    // Check some key tables
    $keyTables = ['users', 'admins', 'products', 'orders', 'payments', 'cart_items'];
    echo "\nChecking key tables:\n";
    foreach ($keyTables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "$table: $count records\n";
        } catch (Exception $e) {
            echo "$table: ERROR - " . $e->getMessage() . "\n";
        }
    }

} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
