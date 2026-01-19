<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "GOOGLE_CLIENT_ID: " . env('GOOGLE_CLIENT_ID', 'NOT SET') . "\n";
echo "GOOGLE_CLIENT_SECRET: " . (env('GOOGLE_CLIENT_SECRET') ? 'SET' : 'NOT SET') . "\n";
echo "GOOGLE_REDIRECT_URL: " . env('GOOGLE_REDIRECT_URL', 'NOT SET') . "\n";
