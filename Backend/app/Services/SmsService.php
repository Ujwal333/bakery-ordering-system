<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SmsService
{
    /**
     * Send OTP via SMS
     * 
     * @param string $phone 10-digit phone number
     * @param string $otp 6-digit OTP code
     * @return bool
     */
    public function sendOtp($phone, $otp)
    {
        $message = "Your Cinnamon Bakery password reset OTP is: {$otp}. Valid for 10 minutes.";
        
        // Log for local development
        Log::info("Attempting SMS to {$phone}: {$message}");

        try {
            // Aakash SMS API Integration (Nepal) v3 Corrected
            $response = Http::get('https://sms.aakashsms.com/sms/v3/send', [
                'auth_token' => config('services.aakash_sms.auth_token'), 
                'to'    => $phone,
                'text'  => $message
            ]);

            if ($response->successful()) {
                Log::info("SMS Sent Successfully to {$phone}");
                return true;
            } else {
                Log::error("Aakash SMS API Error: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("SMS Sending Failed: " . $e->getMessage());
            return false;
        }
    }
}
