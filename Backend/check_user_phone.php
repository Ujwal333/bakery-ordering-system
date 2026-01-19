<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make("Illuminate\Contracts\Console\Kernel")->bootstrap();

use App\Models\User;

$test_phone = '9844810795';

$user = User::where('phone', $test_phone)->first();
if ($user) {
    echo "USER_FOUND: " . $user->name . "\n";
} else {
    echo "USER_NOT_FOUND\n";
}
