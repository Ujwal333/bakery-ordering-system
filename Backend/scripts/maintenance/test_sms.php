<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make("Illuminate\Contracts\Console\Kernel")->bootstrap();

use App\Services\SmsService;

$test_phone = '9844810795'; // Test number
$test_otp = '123456';

echo "Testing SMS to $test_phone...\n";
$sms = new SmsService();
$result = $sms->sendOtp($test_phone, $test_otp);

if ($result) {
    echo "SUCCESS: SMS sent successfully.\n";
} else {
    echo "FAILED: SMS could not be sent. Check logs for details.\n";
}
