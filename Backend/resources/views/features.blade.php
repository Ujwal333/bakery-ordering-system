<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinnamon Bakery - Features</title>
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
            overflow-x: hidden;
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

        /* Hero Section */
        .hero-features {
            background: linear-gradient(rgba(123, 63, 0, 0.85), url('https://images.unsplash.com/photo-1603532648955-a039f8e7d0d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'));
            background-size: cover;
            background-position: center;
            padding: 100px 0 80px;
            color: white;
            text-align: center;
            margin-bottom: 60px;
        }

        .hero-features h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
            color: var(--light);
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .hero-features p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.95;
            color: var(--accent2);
            font-weight: 500;
        }

        /* Features Section */
        .features-intro {
            text-align: center;
            margin-bottom: 50px;
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .features-intro h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 15px;
        }

        .features-intro h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary);
        }

        .features-intro p {
            font-size: 1.1rem;
            color: var(--text);
            margin-bottom: 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-bottom: 80px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-img {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .feature-content {
            padding: 30px;
            flex-grow: 1;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .feature-content h3 {
            font-size: 1.6rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .feature-content p {
            margin-bottom: 20px;
            color: var(--text);
        }

        .feature-benefits {
            background: var(--light);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .feature-benefits h4 {
            font-size: 1.1rem;
            color: var(--secondary);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .feature-benefits ul {
            list-style: none;
            padding-left: 20px;
        }

        .feature-benefits li {
            margin-bottom: 8px;
            position: relative;
            padding-left: 25px;
        }

        .feature-benefits li:before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 2px;
            color: var(--accent);
        }

        /* Gallery Section */
        .gallery-section {
            background: linear-gradient(to right, var(--light) 50%, white 50%);
            padding: 80px 0;
            margin-top: 60px;
        }

        .gallery-container {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .gallery-content {
            flex: 1;
        }

        .gallery-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .gallery-content p {
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .gallery-images {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .gallery-item {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            aspect-ratio: 1/1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item:nth-child(1) {
            grid-row: span 2;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #7B3F00 60%, #e7b07a 100%);
            color: white;
            padding: 60px 0 30px;
            margin-top: 60px;
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
            .gallery-container {
                flex-direction: column;
            }

            .gallery-section {
                background: var(--light);
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

            .hero-features h1 {
                font-size: 2.5rem;
            }

            .hero-features p {
                font-size: 1.1rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .hero-features h1 {
                font-size: 2rem;
            }

            .header-actions {
                gap: 10px;
            }

            .search-bar input {
                width: 120px;
            }

            .gallery-images {
                grid-template-columns: 1fr;
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
                    <li><a href="{{ route('features') }}" class="active">Features</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="profile" id="profile-login-link" style="cursor:pointer;">
                    <a href="{{ route('login') }}" style="display:inline-block;"><img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="profile-img"></a>
                </div>
                <a href="#" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">3</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Title -->
    <div class="container" style="margin-top: 30px; text-align: center;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary); font-weight: 700; letter-spacing: 2px; margin-bottom: 0.5em;">CINNAMON BAKERY</h1>
    </div>

    <!-- Features Intro -->
    <section class="features-intro">
        <div class="container">
            <h2>Our Sweet Features</h2>
            <p>Discover all the ways we make your experience with Cinnamon Bakery delightful, convenient, and memorable. From easy ordering to personalized support, we've baked something special for everyone.</p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="features-grid-section">
        <div class="container">
            <div class="features-grid">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1554119924-8e05546c4d15?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>Easy Online Ordering</h3>
                        <p>Browse our menu, customize your order, and checkout in minutes. Our intuitive interface makes ordering a breeze.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>Simple 3-step ordering process</li>
                                <li>Save favorite items for quick reordering</li>
                                <li>Real-time inventory availability</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1594041680534-e8c8cdebd659?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Live Order Tracking</h3>
                        <p>Follow your order from our bakery to your doorstep in real-time. Know exactly when your treats will arrive.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>Real-time GPS tracking</li>
                                <li>Estimated arrival notifications</li>
                                <li>Driver contact information</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>Recipe & Tips Blog</h3>
                        <p>Access our collection of baking secrets, seasonal recipes, and professional tips to elevate your home baking.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>Weekly new recipes</li>
                                <li>Baking technique videos</li>
                                <li>Seasonal ingredient guides</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <h3>Custom Cake Builder</h3>
                        <p>Design your dream cake with our interactive tool. Choose flavors, frostings, decorations, and personal messages.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>Real-time visual preview</li>
                                <li>Hundreds of design options</li>
                                <li>Instant price calculation</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1607082350899-7e105aa886ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>Secure Payment</h3>
                        <p>Shop with confidence using our bank-level security. Multiple payment options for your convenience.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>Encrypted transactions</li>
                                <li>Multiple payment methods</li>
                                <li>One-click checkout</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1588200908342-23b585c03e26?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Live Chat Support</h3>
                        <p>Get instant help from our baking experts. Available 12 hours a day to answer your questions and solve any issues.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>Real-time assistance</li>
                                <li>Expert baking advice</li>
                                <li>Quick issue resolution</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 7 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1607083206968-13611e3d76db?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Schedule Delivery</h3>
                        <p>Choose the perfect delivery time that fits your schedule. Plan ahead for special occasions with our advance scheduling.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>2-hour delivery windows</li>
                                <li>Schedule up to 30 days in advance</li>
                                <li>Real-time delivery updates</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 8 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Loyalty Program</h3>
                        <p>Earn sweet rewards with every purchase. Enjoy exclusive discounts, early access, and special birthday treats.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits include:</h4>
                            <ul>
                                <li>1 point per rupee (Rs) spent</li>
                                <li>Exclusive member discounts</li>
                                <li>Birthday freebies and surprises</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <div class="gallery-container">
                <div class="gallery-content">
                    <h2>Cinnamon Gallery</h2>
                    <p>Explore our collection of signature creations and customer favorites. Each item is crafted with premium ingredients and artistic passion.</p>
                    <p>From elegant wedding cakes to playful birthday treats, our gallery showcases the range and quality of our bakery's craftsmanship.</p>
                    <button class="btn" style="display: inline-block; background-color: var(--accent); color: #fff; padding: 12px 30px; border-radius: 30px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; border: none; cursor: pointer; box-shadow: 0 2px 8px rgba(255, 159, 28, 0.10);">View Full Gallery</button>
                </div>
                <div class="gallery-images">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1558312651-7d0c7c2d1b13?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Wedding Cake">
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Cupcakes">
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Custom Cake">
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Donuts">
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
        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const nav = document.getElementById('main-nav');

        hamburger.addEventListener('click', () => {
            nav.classList.toggle('active');
        });

        // Update year in footer
        document.querySelector('.copyright p').innerHTML =
            `&copy; ${new Date().getFullYear()} Cinnamon Bakery. All Rights Reserved.`;

        // Animation for feature cards
        const featureCards = document.querySelectorAll('.feature-card');

        featureCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px)';
                card.style.boxShadow = '0 15px 40px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.08)';
            });
        });

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
</body>
</html>
