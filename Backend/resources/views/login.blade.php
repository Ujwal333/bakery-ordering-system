@extends('layouts.app')

@section('title', 'Authentication - Cinnamon Bakery')

@section('styles')
    <style>
        .auth-section { padding: 80px 0; min-height: 80vh; display: flex; align-items: center; background: #fffaf5; }
        .auth-container { max-width: 500px; margin: 0 auto; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(123, 63, 0, 0.08); width: 100%; border: 1px solid #f0e6dc; }
        .auth-header { text-align: center; padding: 40px 40px 20px; }
        .auth-header h1 { font-family: 'Playfair Display', serif; color: var(--secondary); font-size: 32px; margin-bottom: 10px; }
        .auth-tabs { display: flex; border-bottom: 1px solid #f0e6dc; }
        .auth-tab { flex: 1; text-align: center; padding: 15px; cursor: pointer; font-weight: 600; color: #888; transition: all 0.3s; }
        .auth-tab.active { color: var(--primary); border-bottom: 3px solid var(--primary); background: #fffaf5; }
        .auth-forms { padding: 40px; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
        .form-control { width: 100%; padding: 14px 16px; border: 2px solid #f0e6dc; border-radius: 12px; transition: all 0.3s; font-size: 16px; }
        .form-control:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(212, 165, 110, 0.1); }
        .error-message { color: #dc3545; font-size: 12px; margin-top: 5px; display: none; }
        .btn-auth { width: 100%; padding: 16px; border-radius: 12px; border: none; background: linear-gradient(135deg, var(--secondary), var(--primary)); color: white; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(123, 63, 0, 0.15); margin-top: 10px; }
        .password-meter { height: 4px; background: #eee; border-radius: 2px; margin-top: 10px; overflow: hidden; display: none; }
        .meter-bar { height: 100%; width: 0; transition: all 0.3s; }
        .meter-text { font-size: 11px; margin-top: 5px; display: block; color: #888; }
        
        /* OAuth Buttons */
        .divider { text-align: center; margin: 25px 0; position: relative; }
        .divider::before { content: ''; position: absolute; left: 0; top: 50%; width: 100%; height: 1px; background: #e0e0e0; }
        .divider span { position: relative; background: white; padding: 0 15px; color: #888; font-size: 13px; }
        
        .btn-google { width: 100%; padding: 14px; border-radius: 12px; border: 2px solid #e0e0e0; background: white; color: #555; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; margin-bottom: 10px; }
        .btn-google:hover { border-color: #4285f4; background: #f8f9fa; }
        .btn-google img { width: 20px; height: 20px; }
    </style>
@endsection

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="auth-container">
                <div class="auth-header">
                    <h1>Cinnamon Bakery</h1>
                    <p>Nepal's Finest Artisan Bakes</p>
                </div>

                <div class="auth-tabs">
                    <div class="auth-tab active" data-tab="login">Login</div>
                    <div class="auth-tab" data-tab="signup">Sign Up</div>
                </div>

                <div class="auth-forms">
                    <!-- Login Form -->
                    <div class="tab-content active" id="login-tab">
                        <form id="login-form">
                            <div class="form-group">
                                <label>Email or Mobile Number</label>
                                <input type="text" id="login_identifier" class="form-control" placeholder="Email or 98XXXXXXXX" required>
                                <div class="error-message" id="login-id-error"></div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="login_password" class="form-control" placeholder="••••••••" required>
                                <div style="text-align: right; margin-top: 8px;">
                                    <a href="/forgot-password" style="font-size: 13px; color: var(--primary); text-decoration: none; font-weight: 500;">Forgot Password?</a>
                                </div>
                            </div>
                            <button type="submit" class="btn-auth">Sign In</button>
                            
                            <div class="divider"><span>OR</span></div>
                            
                            <a href="{{ route('auth.google') }}" class="btn-google">
                                <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                Continue with Google
                            </a>
                        </form>
                    </div>

                    <!-- Signup Form -->
                    <div class="tab-content" id="signup-tab">
                        <form id="signup-form">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="name" class="form-control" placeholder="E.g. Ram Bahadur" required minlength="3">
                                <div class="error-message" id="name-error"></div>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" id="email" class="form-control" placeholder="name@example.com">
                                <div class="error-message" id="email-error"></div>
                            </div>
                            <div class="form-group">
                                <label>Mobile Number (Nepal)</label>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <span style="font-weight: 700; color: #888;">+977</span>
                                    <input type="tel" id="phone" class="form-control" placeholder="98XXXXXXXX" pattern="9[78]\d{8}">
                                </div>
                                <div class="error-message" id="phone-error"></div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control" placeholder="••••••••" required>
                                <div class="password-meter"><div class="meter-bar"></div></div>
                                <span class="meter-text">Must be 8+ chars with Upper, Lower, Num, Special</span>
                                <div class="error-message" id="password-error"></div>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                                <div class="error-message" id="confirmation-error"></div>
                            </div>
                            <button type="submit" class="btn-auth">Create Account</button>
                            
                            <div class="divider"><span>OR</span></div>
                            
                            <a href="{{ route('auth.google') }}" class="btn-google">
                                <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                Continue with Google
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Tab Switching
        document.querySelectorAll('.auth-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(`${tab.dataset.tab}-tab`).classList.add('active');
            });
        });

        // Validation Regex
        const nepalPhoneRegex = /^9[78]\d{8}$/;
        const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Password Strength Meter
        const passwordInput = document.getElementById('password');
        const meter = document.querySelector('.password-meter');
        const meterBar = document.querySelector('.meter-bar');

        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            meter.style.display = 'block';
            let strength = 0;
            if (val.length >= 8) strength += 25;
            if (/[A-Z]/.test(val)) strength += 25;
            if (/[a-z]/.test(val)) strength += 25;
            if (/[0-9]/.test(val) || /[@$!%*?&]/.test(val)) strength += 25;

            meterBar.style.width = strength + '%';
            meterBar.style.backgroundColor = strength < 50 ? '#dc3545' : (strength < 100 ? '#ffc107' : '#28a745');
        });

        // Handle Signup
        document.getElementById('signup-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const errors = document.querySelectorAll('.error-message');
            errors.forEach(err => err.style.display = 'none');

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            // Client-side quick checks
            if (!email && !phone) {
                showNotification('Either Email or Mobile Number is required.', 'error');
                return;
            }
            if (email && !emailRegex.test(email)) {
                showInlineError('email-error', 'Please enter a valid email address.');
                return;
            }
            if (phone && !nepalPhoneRegex.test(phone)) {
                showInlineError('phone-error', 'Must be a 10-digit number starting with 98 or 97.');
                return;
            }
            if (!strongPasswordRegex.test(password)) {
                showInlineError('password-error', 'Password does not meet security requirements.');
                return;
            }
            if (password !== password_confirmation) {
                showInlineError('confirmation-error', 'Passwords do not match.');
                return;
            }

            try {
                const response = await fetch(`${AUTH_API}/register`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ name, email, phone, password, password_confirmation })
                });
                
                const result = await response.json().catch(() => ({ success: false, message: 'Server error encountered.' }));
                
                if (response.ok && result.success) {
                    showNotification('Account created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect || '/';
                    }, 2000);
                } else {
                    if (result.errors) {
                        handleBackendErrors(result.errors);
                    } else {
                        showNotification(result.message || 'Registration failed.', 'error');
                    }
                }
            } catch (err) {
                showNotification('Error: ' + err.message, 'error');
            }
        });

        // Handle Login
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const login_identifier = document.getElementById('login_identifier').value;
            const password = document.getElementById('login_password').value;

            try {
                const response = await fetch(`${AUTH_API}/login`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ login_identifier, password })
                });

                const result = await response.json().catch(() => ({ success: false, message: 'Server error encountered.' }));

                if (response.ok && result.success) {
                    showNotification(result.message || 'Logged in successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect || '/';
                    }, 2000);
                } else {
                    showNotification(result.message || 'Login failed.', 'error');
                    if (result.suggest_signup) {
                        setTimeout(() => {
                            document.querySelector('[data-tab="signup"]').click();
                        }, 2000);
                    }
                }
            } catch (err) {
                showNotification('Error: ' + err.message, 'error');
            }
        });

        function showInlineError(id, msg) {
            const el = document.getElementById(id);
            el.innerText = msg;
            el.style.display = 'block';
        }

        function handleBackendErrors(errors) {
            for (const field in errors) {
                const errorId = field + '-error';
                if (document.getElementById(errorId)) {
                    showInlineError(errorId, errors[field][0]);
                } else {
                    showNotification(errors[field][0], 'error');
                }
            }
        }
    </script>
@endsection
