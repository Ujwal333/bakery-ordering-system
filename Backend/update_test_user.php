<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make("Illuminate\Contracts\Console\Kernel")->bootstrap();

use App\Models\User;

// Update Gopal (ID 19) with your number for testing
$user = User::where('id', 19)->orWhere('name', 'Gopal')->first();
if ($user) {
    $user->phone = '9844810795';
    $user->save();
    echo "SUCCESS: User " . $user->name . " is now linked to your phone number 9844810795.\n";
} else {
    echo "FAILED: User 'Gopal' not found.\n";
}
