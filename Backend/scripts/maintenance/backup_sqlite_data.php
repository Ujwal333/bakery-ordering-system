<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.database' => __DIR__ . '/bakery_ordering_system']);

$tables = ['users', 'roles', 'products', 'categories', 'orders', 'order_items', 'admins', 'settings'];
$data = [];

echo "Exporting data from SQLite...\n";

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        $rows = DB::table($table)->get()->toArray();
        // Convert objects to arrays
        $data[$table] = array_map(function($item) {
            return (array) $item;
        }, $rows);
        echo " - Exported " . count($rows) . " rows from $table\n";
    } else {
        echo " - Warning: Table $table not found\n";
    }
}

file_put_contents(__DIR__ . '/sqlite_backup_data.json', json_encode($data, JSON_PRETTY_PRINT));
echo "✅ Data backed up to sqlite_backup_data.json\n";
