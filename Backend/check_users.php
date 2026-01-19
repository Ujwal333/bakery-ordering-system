<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::take(3)->get();
foreach ($users as $user) {
    echo 'User: ' . $user->name . ', Role: ' . $user->role . ', Role ID: ' . $user->role_id . PHP_EOL;
}
?>
