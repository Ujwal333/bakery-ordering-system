@extends('layouts.app')

@section('title', 'Forgot Password - Cinnamon Bakery')

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
        .btn-auth { width: 100%; padding: 16px; border-radius: 12px; border: none; background: linear-gradient(135deg, var(--secondary), var(--primary)); color: white; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(123, 63, 0, 0.15); margin-top: 10px; }
        .btn-auth:disabled { opacity: 0.7; cursor: not-allowed; }
        .step-content { display: none; }
        .step-content.active { display: block; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .back-to-login { text-align: center; margin-top: 20px; }
        .back-to-login a { color: var(--primary); font-weight: 600; text-decoration: none; }
        
        /* Method Selection Cards */
        .method-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .method-card { border: 2px solid #f0e6dc; border-radius: 16px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s; }
        .method-card i { font-size: 24px; color: #888; margin-bottom: 10px; display: block; }
        .method-card h3 { font-size: 16px; margin: 0; color: #555; }
        .method-card.selected { border-color: var(--primary); background: #fffaf5; }
        .method-card.selected i { color: var(--primary); }
        .method-card.selected h3 { color: var(--secondary); }
    </style>
@endsection

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="auth-container">
                <div class="auth-header">
                    <h1>Forgot Password?</h1>
                    <p id="step-description">Choose how you want to reset</p>
                </div>

                <div class="auth-forms">
                    <!-- Step 0: Choose Method -->
                    <div class="step-content active" id="step-0">
                        <div class="method-cards">
                            <div class="method-card" onclick="selectMethod('email')">
                                <i class="fas fa-envelope"></i>
                                <h3>Email</h3>
                            </div>
                            <div class="method-card" onclick="selectMethod('phone')">
                                <i class="fas fa-mobile-alt"></i>
                                <h3>Mobile</h3>
                            </div>
                        </div>
                        <p style="text-align: center; color: #888; font-size: 14px;">Select the recovery method linked to your account.</p>
                    </div>

                    <!-- Step 1: Input Identifier -->
                    <div class="step-content" id="step-1">
                        <form id="send-otp-form">
                            <div class="form-group">
                                <label id="identifier-label">Email Address</label>
                                <input type="text" id="identifier" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn-auth" id="send-otp-btn">Send OTP</button>
                            <button type="button" onclick="switchStep(0)" style="background: none; border: none; color: #888; margin-top: 15px; cursor: pointer; width: 100%;">← Change Method</button>
                        </form>
                    </div>

                    <!-- Step 2: Verify OTP -->
                    <div class="step-content" id="step-2">
                        <form id="verify-otp-form">
                            <div class="form-group">
                                <label>Enter 6-Digit OTP</label>
                                <input type="text" id="otp_code" class="form-control" placeholder="XXXXXX" required maxlength="6" pattern="\d{6}">
                                <small style="display: block; margin-top: 10px; color: #888;">OTP sent. <a href="#" onclick="resendOtp(event)" style="color: var(--primary);">Resend?</a></small>
                            </div>
                            <button type="submit" class="btn-auth" id="verify-otp-btn">Verify OTP</button>
                        </form>
                    </div>

                    <!-- Step 3: Reset Password -->
                    <div class="step-content" id="step-3">
                        <form id="reset-password-form">
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" id="new_password" class="form-control" placeholder="••••••••" required minlength="8">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" class="form-control" placeholder="••••••••" required minlength="8">
                            </div>
                            <button type="submit" class="btn-auth" id="reset-password-btn">Reset Password</button>
                        </form>
                    </div>

                    <div class="back-to-login">
                        <a href="/login"><i class="fas fa-arrow-left"></i> Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        let currentIdentifier = '';
        let currentOtp = '';
        let selectedMethod = '';

        function selectMethod(method) {
            selectedMethod = method;
            const label = method === 'email' ? 'Email Address' : 'Mobile Number (10 digits)';
            const placeholder = method === 'email' ? 'name@example.com' : '98XXXXXXXX';
            
            document.getElementById('identifier-label').innerText = label;
            document.getElementById('identifier').placeholder = placeholder;
            document.getElementById('identifier').type = method === 'email' ? 'email' : 'tel';
            
            switchStep(1);
        }

        function switchStep(step) {
            document.querySelectorAll('.step-content').forEach(c => c.classList.remove('active'));
            document.getElementById(`step-${step}`).classList.add('active');
            
            const descriptions = {
                0: 'Choose how you want to reset',
                1: 'Provide your ' + selectedMethod + ' details',
                2: 'We have sent an OTP code',
                3: 'Set your new strong password'
            };
            document.getElementById('step-description').innerText = descriptions[step];
        }

        // Handle Step 1: Send OTP
        document.getElementById('send-otp-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const identifier = document.getElementById('identifier').value;
            const btn = document.getElementById('send-otp-btn');
            
            btn.disabled = true;
            btn.innerText = 'Sending...';

            try {
                const response = await fetch('/forgot-password/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ identifier, method: selectedMethod })
                });

                const result = await response.json();

                if (response.ok) {
                    currentIdentifier = identifier;
                    showNotification(result.message, 'success');
                    if(result.debug_otp) console.log("OTP (Dev):", result.debug_otp);
                    switchStep(2);
                } else {
                    showNotification(result.message || 'Something went wrong', 'error');
                }
            } catch (err) {
                showNotification('Connection error. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Send OTP';
            }
        });

        // Handle Step 2: Verify OTP
        document.getElementById('verify-otp-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const otp = document.getElementById('otp_code').value;
            const btn = document.getElementById('verify-otp-btn');

            btn.disabled = true;
            btn.innerText = 'Verifying...';

            try {
                const response = await fetch('/forgot-password/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ identifier: currentIdentifier, otp, method: selectedMethod })
                });

                const result = await response.json();

                if (response.ok) {
                    currentOtp = otp;
                    showNotification(result.message, 'success');
                    switchStep(3);
                } else {
                    showNotification(result.message || 'Verification failed', 'error');
                }
            } catch (err) {
                showNotification('Connection error.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Verify OTP';
            }
        });

        // Handle Step 3: Reset Password
        document.getElementById('reset-password-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const password = document.getElementById('new_password').value;
            const password_confirmation = document.getElementById('new_password_confirmation').value;
            const btn = document.getElementById('reset-password-btn');

            if (password !== password_confirmation) {
                showNotification('Passwords do not match.', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Resetting...';

            try {
                const response = await fetch('/forgot-password/reset', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        identifier: currentIdentifier, 
                        otp: currentOtp, 
                        password, 
                        password_confirmation 
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification(result.message, 'success');
                    setTimeout(() => window.location.href = '/login', 2000);
                } else {
                    showNotification(result.message || 'Reset failed', 'error');
                }
            } catch (err) {
                showNotification('Connection error.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Reset Password';
            }
        });

        function resendOtp(e) {
            e.preventDefault();
            document.getElementById('send-otp-form').dispatchEvent(new Event('submit'));
        }
    </script>
@endsection
