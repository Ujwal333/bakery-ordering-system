<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Simulate request
$request = new Request();

// Simulate user login
$user = \App\Models\User::first();
if ($user) {
    Auth::login($user);
}

// Call the controller method
$controller = new \App\Http\Controllers\CartController();
$response = $controller->index($request);

echo "API Response (logged in):\n";
echo $response->getContent() . "\n";
