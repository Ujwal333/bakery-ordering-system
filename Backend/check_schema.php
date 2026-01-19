<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
echo 'Users table columns: ' . implode(', ', $columns) . PHP_EOL;

$columns = \Illuminate\Support\Facades\Schema::getColumnListing('admins');
echo 'Admins table columns: ' . implode(', ', $columns) . PHP_EOL;
?>
