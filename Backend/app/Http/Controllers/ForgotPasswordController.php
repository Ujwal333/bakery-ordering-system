<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Services\SmsService;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'method' => 'required|in:email,phone',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Valid identifier and method are required.'], 422);
        }

        $identifier = $request->identifier;
        $method = $request->method;

        $user = User::where($method, $identifier)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => "No account found with this {$method}."], 404);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        if ($method === 'phone') {
            $sms = new SmsService();
            $sms->sendOtp($user->phone, $otp);
            $displayMsg = "OTP has been sent to your mobile number via SMS.";
        } else {
            // Email Logic
            try {
                Mail::raw("Your Cinnamon Bakery password reset OTP is: {$otp}", function($message) use ($user) {
                    $message->to($user->email)->subject('Password Reset OTP');
                });
                $displayMsg = "OTP has been sent to your email address.";
            } catch (\Exception $e) {
                Log::error("Email failed: " . $e->getMessage());
                // Fallback for dev
                $displayMsg = "OTP generated (Email sending failed/not configured).";
            }
        }

        return response()->json([
            'success' => true, 
            'message' => $displayMsg,
            'debug_otp' => $otp
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid data provided.'], 422);
        }

        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->first();

        if (!$user || $user->otp_code !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP code.'], 422);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new one.'], 422);
        }

        return response()->json(['success' => true, 'message' => 'OTP verified successfully. You can now reset your password.']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->first();

        if (!$user || $user->otp_code !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Security check failed. Please restart the process.'], 422);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'Session expired.'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password reset successfully! You can now log in.']);
    }
}
