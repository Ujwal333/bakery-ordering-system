@extends('layouts.app')

@section('title', 'Account - Cinnamon Bakery')

@section('styles')
    <style>
        .account-section { padding: 80px 0; min-height: 70vh; display: flex; align-items: center; }
        .account-container { display: flex; max-width: 1000px; margin: 0 auto; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1); width: 100%; }
        .account-image { flex: 1; background: linear-gradient(rgba(123, 63, 0, 0.7), rgba(123, 63, 0, 0.7)), url('https://images.unsplash.com/photo-1568254183919-78a4f43a2877?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: center; padding: 40px; color: white; position: relative; }
        .account-image h1 { font-family: 'Playfair Display', serif; font-size: 36px; margin-bottom: 20px; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); position: relative; z-index: 2; }
        .account-image p { font-size: 18px; margin-bottom: 20px; opacity: 0.9; position: relative; z-index: 2; }
        .account-forms { flex: 1; padding: 50px; }
        .tabs { display: flex; border-bottom: 2px solid #f0e6dc; margin-bottom: 30px; }
        .tab { padding: 15px 30px; cursor: pointer; font-weight: 600; color: #888; transition: all 0.3s ease; }
        .tab.active { color: var(--secondary); border-bottom: 3px solid var(--primary); }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .btn-full { display: block; width: 100%; background: linear-gradient(to right, var(--secondary), var(--primary)); color: white; border: none; padding: 16px; border-radius: 10px; font-size: 18px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-top: 20px; }
        @media (max-width: 992px) { .account-container { flex-direction: column; } }
    </style>
@endsection

@section('content')
    <section class="account-section">
        <div class="container">
            <div class="account-container">
                <div class="account-image">
                    <h1>Welcome to Cinnamon Bakery</h1>
                    <p>Create an account to save your preferences and track orders.</p>
                </div>

                <div class="account-forms">
                    <div class="tabs">
                        <div class="tab active" data-tab="login">Login</div>
                        <div class="tab" data-tab="signup">Sign Up</div>
                        <div class="tab" data-tab="otp">OTP Login</div>
                    </div>

                    <!-- Login Form -->
                    <div class="tab-content active" id="login-content">
                        <form id="login-form">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="login-email" class="form-control" required placeholder="your@email.com">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="login-password" class="form-control" required placeholder="******">
                            </div>
                            <button type="submit" class="btn-full">Login</button>
                        </form>
                    </div>

                    <!-- Signup Form -->
                    <div class="tab-content" id="signup-content">
                        <form id="signup-form">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="username" class="form-control" required placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" class="form-control" required placeholder="your@email.com">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control" required placeholder="******">
                            </div>
                            <button type="submit" class="btn-full">Sign Up</button>
                        </form>
                    </div>

                    <!-- OTP Form -->
                    <div class="tab-content" id="otp-content">
                        <form id="otp-send-form">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="otp-email" class="form-control" required placeholder="your@email.com">
                            </div>
                            <button type="submit" class="btn-full">Send OTP</button>
                        </form>
                        <form id="otp-verify-form" style="display:none; margin-top:20px;">
                            <div class="form-group">
                                <label>Enter OTP</label>
                                <input type="text" id="otp-code" class="form-control" required placeholder="XXXXXX">
                            </div>
                            <button type="submit" class="btn-full">Verify & Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(`${tab.dataset.tab}-content`).classList.add('active');
            });
        });

        // Form handlers (Simplified for refactor)
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            
            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ email, password })
                });
                const result = await response.json();
                if (response.ok) {
                    showNotification('Login successful!');
                    window.location.href = '/';
                } else {
                    showNotification(result.message || 'Login failed', 'error');
                }
            } catch (err) { console.error(err); }
        });

        // OTP Handlers
        document.getElementById('otp-send-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('otp-email').value;
            try {
                const response = await fetch('/api/send-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ email })
                });
                const result = await response.json();
                if (response.ok) {
                    showNotification('OTP Sent!');
                    document.getElementById('otp-send-form').style.display = 'none';
                    document.getElementById('otp-verify-form').style.display = 'block';
                }
            } catch (err) { console.error(err); }
        });

        document.getElementById('otp-verify-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('otp-email').value;
            const otp = document.getElementById('otp-code').value;
            try {
                const response = await fetch('/api/verify-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ email, otp })
                });
                const result = await response.json();
                if (response.ok) {
                    showNotification('OTP Verified!');
                    window.location.href = '/';
                }
            } catch (err) { console.error(err); }
        });
    </script>
@endsection
