<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

config(['database.default' => 'mysql']);

$tables = ['user_addresses', 'saved_items', 'payment_logs', 'events', 'pages'];
foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        echo "✅ Table '$table' exists.\n";
    } else {
        echo "❌ Table '$table' MISSING!\n";
    }
}
