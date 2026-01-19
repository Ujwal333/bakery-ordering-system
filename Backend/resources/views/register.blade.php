@extends('layouts.app')

@section('title', 'Sign Up - Cinnamon Bakery')

@section('styles')
    <style>
        .auth-section { padding: 80px 0; min-height: 80vh; display: flex; align-items: center; background: #fffaf5; }
        .auth-container { max-width: 500px; margin: 0 auto; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(123, 63, 0, 0.08); width: 100%; border: 1px solid #f0e6dc; }
        .auth-header { text-align: center; padding: 40px 40px 20px; }
        .auth-header h1 { font-family: 'Playfair Display', serif; color: var(--secondary); font-size: 32px; margin-bottom: 10px; }
        .auth-forms { padding: 40px; }
        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
        .form-control { width: 100%; padding: 14px 16px; border: 2px solid #f0e6dc; border-radius: 12px; transition: all 0.3s; font-size: 16px; }
        .form-control:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(212, 165, 110, 0.1); }
        .error-message { color: #dc3545; font-size: 12px; margin-top: 5px; display: none; }
        .btn-auth { width: 100%; padding: 16px; border-radius: 12px; border: none; background: linear-gradient(135deg, var(--secondary), var(--primary)); color: white; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(123, 63, 0, 0.15); margin-top: 10px; }
        .password-meter { height: 4px; background: #eee; border-radius: 2px; margin-top: 10px; overflow: hidden; }
        .meter-bar { height: 100%; width: 0; transition: all 0.3s; }
        .meter-text { font-size: 11px; margin-top: 5px; display: block; color: #888; }
        .login-link { text-align: center; margin-top: 20px; color: #888; }
        .login-link a { color: var(--primary); font-weight: 600; text-decoration: none; }
    </style>
@endsection

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="auth-container">
                <div class="auth-header">
                    <h1>Create Account</h1>
                    <p>Join Cinnamon Bakery</p>
                </div>

                <div class="auth-forms">
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
                    </form>
                    <div class="login-link">
                        Already have an account? <a href="/login">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const nepalPhoneRegex = /^9[78]\d{8}$/;
        const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        const passwordInput = document.getElementById('password');
        const meterBar = document.querySelector('.meter-bar');



        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            let strength = 0;
            if (val.length >= 8) strength += 25;
            if (/[A-Z]/.test(val)) strength += 25;
            if (/[a-z]/.test(val)) strength += 25;
            if (/[0-9]/.test(val) || /[@$!%*?&]/.test(val)) strength += 25;

            meterBar.style.width = strength + '%';
            meterBar.style.backgroundColor = strength < 50 ? '#dc3545' : (strength < 100 ? '#ffc107' : '#28a745');
        });

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

            // Disable submit button
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating Account...';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    throw new Error('Security token missing. Please refresh the page.');
                }

                const response = await fetch('/register', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ name, email, phone, password, password_confirmation })
                });

                let result;
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    result = await response.json();
                } else {
                    const errorText = await response.text();
                    console.error('Non-JSON response:', errorText);
                    if (response.status === 419) {
                        throw new Error('Your session has expired. Please refresh the page and try again.');
                    }
                    throw new Error('Server error (Status ' + response.status + '). Please try again later.');
                }
                
                if (response.ok && result.success) {
                    showNotification('Account created successfully!', 'success');
                    setTimeout(() => window.location.href = result.redirect || '/', 2000);
                } else {
                    if (result.errors) {
                        handleBackendErrors(result.errors);
                    } else {
                        showNotification(result.message || 'Registration failed', 'error');
                    }
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Create Account';
                }
            } catch (err) {
                console.error('Registration error detail:', err);
                showNotification(err.message || 'Connection error. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Account';
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
