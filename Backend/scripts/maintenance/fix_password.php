<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admin = \App\Models\Admin::where('email', 'admin@bakery.com')->first();
if($admin) {
    $admin->password = \Illuminate\Support\Facades\Hash::make('admin123');
    $admin->save();
    echo "Password updated successfully.\n";
} else {
    echo "Admin not found.\n";
}
