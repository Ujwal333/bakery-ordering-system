<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Cinnamon Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #D4A76A;
            --secondary: #7B3F00;
            --light: #FFF8F0;
            --dark: #1E1E1E;
            --accent: #FF9F1C;
            --accent2: #f7c873;
            --text: #333333;
            --card: #f9ede5;
            --gradient: linear-gradient(90deg, #fff8f0 0%, #ffe5d0 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(90deg, #fff8f0 60%, #ffe5d0 100%);
            box-shadow: 0 2px 10px rgba(231, 176, 122, 0.13);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--secondary);
            display: flex;
            align-items: center;
        }

        .logo i {
            color: var(--primary);
            margin-right: 10px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--secondary);
            font-weight: 600;
            font-size: 16px;
            position: relative;
            transition: all 0.3s ease;
            padding: 4px 10px;
            border-radius: 6px;
        }

        nav ul li a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent);
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }

        nav ul li a:hover,
        nav ul li a.active {
            background: var(--accent2);
            color: var(--dark);
        }
        nav ul li a:hover:after,
        nav ul li a.active:after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: var(--card);
            border-radius: 30px;
            padding: 8px 15px;
            box-shadow: 0 2px 8px rgba(231, 176, 122, 0.08);
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 180px;
            font-size: 14px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
        }

        .cart-icon {
            position: relative;
            font-size: 20px;
            color: var(--dark);
            background: var(--card);
            border-radius: 50%;
            padding: 8px;
            transition: background 0.2s;
        }
        .cart-icon:hover {
            background: var(--accent2);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(231, 176, 122, 0.12);
        }

        .hamburger {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* Account Section */
        .account-section {
            padding: 80px 0;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }

        .account-container {
            display: flex;
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .account-image {
            flex: 1;
            background: linear-gradient(rgba(123, 63, 0, 0.7), rgba(123, 63, 0, 0.7)), url('https://images.unsplash.com/photo-1568254183919-78a4f43a2877?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: white;
            position: relative;
        }

        .account-image h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            margin-bottom: 20px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .account-image p {
            font-size: 18px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .account-image::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, var(--secondary), transparent);
            z-index: 1;
        }

        .account-image-content {
            position: relative;
            z-index: 2;
        }

        .account-forms {
            flex: 1;
            padding: 50px;
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #f0e6dc;
            margin-bottom: 30px;
        }

        .tab {
            padding: 15px 30px;
            cursor: pointer;
            font-weight: 600;
            color: #888;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: var(--secondary);
            border-bottom: 3px solid var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }

        .input-icon input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0d6c9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-icon input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 168, 106, 0.2);
        }

        .btn {
            display: block;
            width: 100%;
            background: linear-gradient(to right, var(--secondary), var(--primary));
            color: white;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(123, 63, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(123, 63, 0, 0.3);
        }

        .account-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .account-footer a {
            color: var(--secondary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .account-footer a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #7B3F00 60%, #e7b07a 100%);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h3 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #e0d7d5;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            color: #e0d7d5;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .account-container {
                flex-direction: column;
            }

            .account-image {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                flex-wrap: wrap;
            }

            nav {
                order: 3;
                width: 100%;
                margin-top: 15px;
                display: none;
            }

            nav.active {
                display: block;
            }

            nav ul {
                flex-direction: column;
                gap: 10px;
            }

            .hamburger {
                display: block;
            }

            .account-forms {
                padding: 30px;
            }

            .tabs {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .header-actions {
                gap: 10px;
            }

            .search-bar input {
                width: 120px;
            }

            .account-section {
                padding: 40px 0;
            }

            .tabs {
                flex-direction: column;
            }

            .tab {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <nav id="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('browse-menu') }}" class="{{ request()->is('browse-menu') ? 'active' : '' }}">Browse Menu</a></li>
                    <li><a href="{{ route('custom-cake') }}">Custom Cakes</a></li>
                    <li><a href="{{ route('order-tracking') }}">Order Tracking</a></li>
                    <li><a href="{{ route('about') }}">About / Events</a></li>
                    <li><a href="{{ route('features') }}">Features</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="profile" id="profile-login-link" style="cursor:pointer;">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="profile-img">
                </div>
                <a href="#" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">3</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Account Section -->
    <section class="account-section">
        <div class="account-container">
            <div class="account-image">
                <div class="account-image-content">
                    <h1>Welcome to Cinnamon Bakery</h1>
                    <p>Create an account to save your preferences, track orders, and receive exclusive offers.</p>
                    <p>Already have an account? Sign in to access your personalized bakery experience.</p>
                </div>
            </div>

            <div class="account-forms">
                <div class="tabs">
                    <div class="tab active" data-tab="signup">Sign Up</div>
                    <div class="tab" data-tab="login">Login</div>
                </div>

                <!-- Signup Form -->
                <div class="tab-content active" id="signup-content">
                    <form id="signup-form">
                        <div class="form-group">
                            <label for="username">User name</label>
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="username" placeholder="Enter your username" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" placeholder="Create a password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn">Sign Up</button>
                    </form>

                    <div class="account-footer">
                        Already have an account? <a href="#" id="login-link">Login</a>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="tab-content" id="login-content">
                    <form id="login-form">
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="login-email" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="login-password" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <div class="account-footer" style="text-align: right; margin-top: -10px;">
                            <a href="#">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn">Login</button>
                    </form>

                    <div class="account-footer">
                        Don't have an account? <a href="#" id="signup-link">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Cinnamon Bakery</h3>
                    <p>Artisan bakery crafting delicious treats since 2010. Quality ingredients, traditional methods, modern flavors.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('browse-menu') }}">Browse Menu</a></li>
                        <li><a href="{{ route('custom-cake') }}">Custom Cakes</a></li>
                        <li><a href="{{ route('order-tracking') }}">Order Tracking</a></li>
                        <li><a href="{{ route('about') }}">About / Events</a></li>
                        <li><a href="{{ route('features') }}">Features</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Sano Bharayang, Kathmandu, Nepal</li>
                        <li><i class="fas fa-phone"></i> +977 9769349551</li>
                        <li><i class="fas fa-envelope"></i> cinnamonbakery79@gmail.com</li>
                        <li><i class="fas fa-clock"></i> Open Daily: 8AM - 8PM</li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2023 Cinnamon Bakery. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle (no hamburger in this header)
        const nav = document.getElementById('main-nav');
        // Update year in footer
        document.querySelector('.copyright p').innerHTML =
            `&copy; ${new Date().getFullYear()} Cinnamon Bakery. All Rights Reserved.`;

        // Profile click - since we're already on login page, maybe show a message or do nothing
        document.getElementById('profile-login-link').addEventListener('click', function() {
            // Already on login page, maybe scroll to top or show message
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const loginLink = document.getElementById('login-link');
        const signupLink = document.getElementById('signup-link');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Hide all tab content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Show the corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(`${tabId}-content`).classList.add('active');
            });
        });

        // Link functionality
        loginLink.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.tab[data-tab="login"]').click();
        });

        signupLink.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.tab[data-tab="signup"]').click();
        });

        // Registration form submission
        document.getElementById('signup-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('signup-name').value;
            const email = document.getElementById('signup-email').value;
            const password = document.getElementById('signup-password').value;
            const passwordConfirm = document.getElementById('signup-password-confirm').value;

            if (password !== passwordConfirm) {
                showNotification('Passwords do not match', 'error');
                return;
            }

            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating Account...';

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                        password_confirmation: passwordConfirm
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification('Account created successfully! Please login.', 'success');
                    // Clear form
                    e.target.reset();
                    // Switch to login tab
                    setTimeout(() => {
                        document.querySelector('.tab[data-tab="login"]').click();
                    }, 1500);
                } else {
                    showNotification(result.message || 'Registration failed', 'error');
                }
            } catch (error) {
                console.error('Registration error:', error);
                showNotification('An error occurred during registration', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Login form submission
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging in...';

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification('Login successful! Redirecting...', 'success');
                    // Store token if needed (though we're using session-based auth)
                    localStorage.setItem('auth_token', result.token || '');
                    // Redirect to home page
                    setTimeout(() => {
                        window.location.href = '{{ route("home") }}';
                    }, 1500);
                } else {
                    showNotification(result.message || 'Login failed', 'error');
                }
            } catch (error) {
                console.error('Login error:', error);
                showNotification('An error occurred during login', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: 500;
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
            `;

            if (type === 'success') {
                notification.style.backgroundColor = '#4CAF50';
            } else {
                notification.style.backgroundColor = '#f44336';
            }

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Update cart count
        async function updateCartCount() {
            try {
                const response = await fetch('/api/cart/count');
                const data = await response.json();
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count || 0;
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        // Initialize cart count on page load
        updateCartCount();
    </script>
    </script>
</body>
</html>
