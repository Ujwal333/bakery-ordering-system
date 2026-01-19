<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;

class LoginController extends Controller
{
    protected $redirectTo = '/admin/dashboard';
    protected $maxAttempts = 5;
    protected $decayMinutes = 1;

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'login'    => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $request->login,
            'password'  => $request->password,
            'status'    => 'active'
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome to the admin dashboard!');
        }

        $this->incrementLoginAttempts($request);

        return back()->withEmail($request->login)->withErrors([
            'login' => 'The provided credentials do not match our records or the account is inactive.',
        ]);
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), $this->maxAttempts);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit($this->throttleKey($request), $this->decayMinutes * 60);
    }

    protected function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('login')) . '|' . $request->ip();
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw \Illuminate\Validation\ValidationException::withMessages([
            'login' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(429);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been logged out.');
    }

    protected function username()
    {
        return 'login';
    }
}
