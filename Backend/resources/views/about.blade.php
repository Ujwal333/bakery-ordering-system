<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Cinnamon Bakery</title>
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--gradient); color: var(--text); line-height: 1.6; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        header { background: linear-gradient(90deg, #fff8f0 60%, #ffe5d0 100%); box-shadow: 0 2px 10px rgba(231, 176, 122, 0.13); position: sticky; top: 0; z-index: 100; }
        .header-container { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; }
        .logo { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: var(--secondary); display: flex; align-items: center; }
        .logo i { color: var(--primary); margin-right: 10px; }
        nav ul { display: flex; list-style: none; gap: 25px; }
        nav ul li a { text-decoration: none; color: var(--secondary); font-weight: 600; font-size: 16px; position: relative; transition: all 0.3s ease; padding: 4px 10px; border-radius: 6px; }
        nav ul li a:after { content: ''; position: absolute; width: 0; height: 2px; background: var(--accent); bottom: -5px; left: 0; transition: width 0.3s; }
        nav ul li a:hover, nav ul li a.active { background: var(--accent2); color: var(--dark); }
        nav ul li a:hover:after, nav ul li a.active:after { width: 100%; }
        .header-actions { display: flex; align-items: center; gap: 20px; }
        .search-bar { display: flex; align-items: center; background: var(--card); border-radius: 30px; padding: 8px 15px; box-shadow: 0 2px 8px rgba(231, 176, 122, 0.08); }
        .search-bar input { border: none; background: transparent; outline: none; width: 180px; font-size: 14px; }
        .profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent); }
        .cart-icon { position: relative; font-size: 20px; color: var(--dark); background: var(--card); border-radius: 50%; padding: 8px; transition: background 0.2s; }
        .cart-icon:hover { background: var(--accent2); }
        .cart-count { position: absolute; top: -8px; right: -8px; background-color: var(--accent); color: white; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(231, 176, 122, 0.12); }
        .hamburger { display: none; font-size: 24px; cursor: pointer; }
        footer { background: linear-gradient(90deg, #7B3F00 60%, #e7b07a 100%); color: white; padding: 60px 0 30px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px; }
        .footer-col h3 { font-family: 'Playfair Display', serif; font-size: 24px; margin-bottom: 20px; position: relative; padding-bottom: 10px; }
        .footer-col h3:after { content: ''; position: absolute; bottom: 0; left: 0; width: 50px; height: 2px; background-color: var(--primary); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #e0d7d5; transition: all 0.3s ease; }
        .footer-links a:hover { color: white; padding-left: 5px; }
        .social-links { display: flex; gap: 15px; margin-top: 20px; }
        .social-links a { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; color: white; transition: all 0.3s ease; }
        .social-links a:hover { background-color: var(--primary); transform: translateY(-3px); }
        .copyright { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; color: #e0d7d5; }
        @media (max-width: 768px) { .header-container { flex-wrap: wrap; } nav { order: 3; width: 100%; margin-top: 15px; display: none; } nav.active { display: block; } nav ul { flex-direction: column; gap: 10px; } .hamburger { display: block; } }

        /* New About Page Styles */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1608190003443-86b2636f2fe3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
        }
        .hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
            color: white;
        }
        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .about-container {
            display: flex;
            gap: 40px;
            margin: 80px auto;
            max-width: 1200px;
        }
        .about-content, .events-content {
            flex: 1;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            padding: 40px;
        }
        .about-content h2, .events-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--secondary);
            margin-bottom: 25px;
            position: relative;
        }
        .about-content h2::after, .events-content h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--primary);
        }
        .about-image {
            width: 100%;
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            margin: 25px 0;
            background: url('https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') no-repeat center center;
            background-size: cover;
        }
        .about-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            color: var(--text);
        }
        .event-card {
            background: var(--light);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
        }
        .event-card h3 {
            font-size: 1.4rem;
            color: var(--secondary);
            margin-bottom: 10px;
        }
        .event-date {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .event-card p {
            color: var(--text);
            line-height: 1.7;
        }
        .quote-section {
            background: url('https://images.unsplash.com/photo-1541701494587-cb58502866ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
            padding: 100px 0;
            text-align: center;
            position: relative;
            margin-bottom: 80px;
        }
        .quote-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(123, 63, 0, 0.7);
        }
        .quote-content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .quote-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .quote-content p {
            font-size: 1.2rem;
            font-style: italic;
            line-height: 1.8;
        }
        @media (max-width: 992px) {
            .about-container {
                flex-direction: column;
            }
            .hero-content h1 {
                font-size: 3rem;
            }
        }
        @media (max-width: 768px) {
            .hero-section {
                height: 300px;
            }
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .about-content, .events-content {
                padding: 25px;
            }
        }
        @media (max-width: 576px) {
            .hero-section {
                height: 250px;
            }
            .hero-content h1 {
                font-size: 2rem;
            }
            .quote-content h3 {
                font-size: 2rem;
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
                    <li><a href="{{ route('about') }}" class="active">About / Events</a></li>
                    <li><a href="{{ route('features') }}">Features</a></li>
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
                <div class="hamburger" id="hamburger">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>About</h1>
        </div>
    </section>

    <!-- About & Events Section -->
    <div class="container about-container">
        <!-- About Content -->
        <div class="about-content">
            <h2>About</h2>
            <p>Welcome to Cinnamon Bakery! Established in 2022, we've been crafting delicious treats with love and the finest ingredients. Our passion for baking shines through in every cake, pastry, and loaf we make.</p>

            <!-- Baked item images only -->
            <div class="about-image" style="background: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') no-repeat center center; background-size: cover;"></div>
            <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cupcakes" style="width:100%; border-radius:10px; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08);">
            <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cookies" style="width:100%; border-radius:10px; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08);">
            <img src="https://images.unsplash.com/photo-1607082350899-7e105aa886ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Pastries" style="width:100%; border-radius:10px; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08);">

            <p>We specialize in traditional baking methods using premium ingredients to create exceptional baked goods that cater to all tastes. From our signature cinnamon rolls to custom celebration cakes, every item is made with attention to detail and a commitment to quality.</p>

            <img src="https://images.unsplash.com/photo-1541701494587-cb58502866ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cinnamon Rolls" style="width:100%; border-radius:10px; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08);">

            <p>Our bakery in Sano Bharayang, Kathmandu has become a beloved local institution where people gather to enjoy our freshly baked goods and warm atmosphere. We believe in creating community through shared food experiences.</p>

            <img src="https://images.unsplash.com/photo-1608190003443-86b2636f1ce6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fresh Bread" style="width:100%; border-radius:10px; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08);">

            <p>Whether you're celebrating a special occasion or just want to treat yourself, we're here to make your day sweeter. Visit us today and taste the difference that passion and quality ingredients make!</p>
        </div>

        <!-- Events Content -->
        <div class="events-content">
            <h2>Events</h2>
            <div class="event-card">
                <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Baking Masterclass" style="width:100%; border-radius:8px; margin-bottom:15px;">
                <h3>Baking Masterclass</h3>
                <span class="event-date">June 15, 2023</span>
                <p>Join our head pastry chef for a hands-on baking masterclass. Learn professional techniques for creating perfect pastries, cakes, and artisan breads. Limited spots available!</p>
            </div>
            <div class="event-card">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Cinnamon Roll Day" style="width:100%; border-radius:8px; margin-bottom:15px;">
                <h3>Cinnamon Roll Day</h3>
                <span class="event-date">July 7, 2023</span>
                <p>Celebrate National Cinnamon Roll Day with us! Enjoy special discounts on all cinnamon products, live music, and free samples of our new seasonal variations.</p>
            </div>
            <div class="event-card">
                <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Kids Baking Workshop" style="width:100%; border-radius:8px; margin-bottom:15px;">
                <h3>Kids Baking Workshop</h3>
                <span class="event-date">August 12, 2023</span>
                <p>A fun-filled workshop where children can learn baking basics in a safe environment. They'll decorate cupcakes and cookies to take home. Perfect for ages 6-12.</p>
            </div>
            <div class="event-card">
                <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Seasonal Pie Festival" style="width:100%; border-radius:8px; margin-bottom:15px;">
                <h3>Seasonal Pie Festival</h3>
                <span class="event-date">September 23, 2023</span>
                <p>Celebrate the arrival of autumn with our annual pie festival. Sample our wide variety of seasonal pies, from classic apple to unique pumpkin spice creations.</p>
            </div>
        </div>
    </div>

    <!-- Quote Section -->
    <section class="quote-section">
        <div class="quote-content">
            <h3>Cinnamon Bakery</h3>
            <p>A collection of recipes and traditions passed down through generations. Bringing the warmth of homemade baking with premium ingredients and no compromises. Our passion is creating sweet moments that bring people together.</p>
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
                        <li><a href="{{ route('about') }}">About Us</a></li>
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
        hamburger.addEventListener('click', () => { nav.classList.toggle('active'); });
        // Update year in footer
        document.querySelector('.copyright p').innerHTML = `&copy; ${new Date().getFullYear()} Cinnamon Bakery. All Rights Reserved.`;

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
