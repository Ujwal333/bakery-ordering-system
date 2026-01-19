<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admins = App\Models\Admin::take(3)->get();
foreach ($admins as $admin) {
    echo 'Admin: ' . $admin->name . ', Email: ' . $admin->email . ', Role: ' . $admin->role . PHP_EOL;
}
?>
