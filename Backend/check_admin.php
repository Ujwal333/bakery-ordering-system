<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'Admins count: ' . App\Models\Admin::count() . PHP_EOL;
$admin = App\Models\Admin::first();
if($admin) {
    echo 'First admin: ' . $admin->email . PHP_EOL;
    echo 'Password hash: ' . $admin->password . PHP_EOL;
}
?>
