<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Added
use Illuminate\Support\Str;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterRequest $request)
    {
        try {
            Log::info('Registering user: ' . $request->email); // Debug log

            $userRole = \App\Models\Role::where('slug', 'customer')->first();
            
            // Explicitly verify role found or fallback
            $roleId = $userRole ? $userRole->id : 1;
            Log::info('Assigning Role ID: ' . $roleId);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address ?? '', 
                'role_id' => $roleId, 
                'profile_image' => 'https://randomuser.me/api/portraits/' .
                    (rand(0, 1) ? 'men' : 'women') . '/' . rand(1, 70) . '.jpg',
            ]);

            // Log the user in for the session
            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! You can now add items to your cart.',
                'user' => $user,
                'token' => $token,
                'redirect' => '/'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create account: ' . $e->getMessage()
            ], 500);
        }
    }

    // Login user
    public function login(LoginRequest $request)
    {
        $identifier = $request->login_identifier;
        $password = $request->password;

        // Check if identifier is email or phone
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Explicit check for user existence to prompt signup
        $userExists = User::where($fieldType, $identifier)->exists();
        if (!$userExists) {
            return response()->json([
                'success' => false,
                'message' => "No account found with this " . ($fieldType == 'email' ? 'email' : 'mobile number') . ". Please sign up first.",
                'suggest_signup' => true
            ], 404);
        }

        if (!Auth::attempt([$fieldType => $identifier, 'password' => $password])) {
            return response()->json([
                'success' => false,
                'message' => "Invalid login credentials. Please check your " . ($fieldType == 'email' ? 'email' : 'mobile number') . "."
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Welcome back, ' . $user->name,
            'user' => $user,
            'token' => $token,
            'redirect' => '/'
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $user = $request->user();
        
        if ($user && method_exists($user, 'currentAccessToken')) {
            $token = $user->currentAccessToken();
            // Only try to delete if it's a persistent token (has an ID/exists in DB)
            if ($token && !($token instanceof \Laravel\Sanctum\TransientToken)) {
                $token->delete();
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
                'redirect' => '/'
            ]);
        }

        return redirect('/')->with('success', 'Logged out successfully');
    }

    // Get current user
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only('name', 'email', 'phone', 'address'));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
