<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

config(['database.default' => 'mysql']);

$counts = [
    'users' => DB::table('users')->count(),
    'categories' => DB::table('categories')->count(),
    'products' => DB::table('products')->count(),
    'orders' => DB::table('orders')->count(),
];

print_r($counts);
