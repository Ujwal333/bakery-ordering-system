<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $count = \Illuminate\Support\Facades\DB::table('payment_logs')->count();
    echo 'Payment logs count: ' . $count . PHP_EOL;
} catch (Exception $e) {
    echo 'Payment logs table error: ' . $e->getMessage() . PHP_EOL;
}

try {
    $count = \Illuminate\Support\Facades\DB::table('payments')->count();
    echo 'Payments count: ' . $count . PHP_EOL;
} catch (Exception $e) {
    echo 'Payments table error: ' . $e->getMessage() . PHP_EOL;
}
?>
