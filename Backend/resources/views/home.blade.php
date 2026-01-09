@extends('layouts.app')

@section('title', 'Cinnamon Bakery - Home')

@section('styles')
    <style>
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), url('https://images.unsplash.com/photo-1608190003443-86b2636f1ce6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'));
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            margin-bottom: 20px;
            line-height: 1.2;
            color: var(--primary);
            text-shadow: 0 2px 8px rgba(212, 167, 106, 0.15);
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.95;
            color: var(--accent);
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(255, 159, 28, 0.10);
            margin-right: 10px;
        }
        .btn:hover {
            background-color: var(--secondary);
            color: #fff;
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 5px 15px rgba(123, 63, 0, 0.13);
        }
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--secondary);
            color: var(--secondary);
            margin-left: 0;
            margin-right: 0;
        }
        .btn-outline:hover {
            background-color: var(--secondary);
            color: #fff;
            border-color: var(--secondary);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: var(--light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(231, 176, 122, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 167, 106, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(231, 176, 122, 0.15);
            border-color: var(--primary);
        }

        .feature-icon {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 25px;
        }

        .feature-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            margin-bottom: 15px;
            color: var(--secondary);
        }

        /* Testimonials Section */
        .testimonials {
            padding: 100px 0;
            background: var(--gradient);
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(231, 176, 122, 0.08);
            border-left: 5px solid var(--primary);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 25px;
            font-size: 16px;
        }

        .customer {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .customer-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .customer-name {
            font-weight: 600;
            color: var(--secondary);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--primary);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 28px;
            }

            .section-title h2 {
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Main Title -->
    <div class="container" style="margin-top: 30px; text-align: center;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary); font-weight: 700; letter-spacing: 2px; margin-bottom: 0.5em;">CINNAMON BAKERY</h1>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <h1>Artisan Bakery Crafted with Love</h1>
            <p>Discover our handcrafted pastries, cakes, and breads made with premium ingredients</p>
            <div>
                <a href="{{ route('browse-menu') }}" class="btn">Order Now</a>
                <a href="{{ route('browse-menu') }}" class="btn btn-outline">View Menu</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <a class="feature-card" href="{{ route('browse-menu') }}" style="text-decoration: none; color: inherit;">
                    <div class="feature-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>Browse Menu</h3>
                    <p>Explore our wide selection of delicious baked goods and desserts</p>
                </a>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>Place Your Order</h3>
                    <p>Easy online ordering with secure payment options</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Fast Delivery</h3>
                    <p>Quick and reliable delivery to your doorstep</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Sellers -->
    <section id="menu" style="padding: 80px 0;">
        <div class="container">
            <div class="section-title">
                <p>Most Loved</p>
                <h2>Our Best Sellers</h2>
            </div>
            <div class="testimonial-grid">
                @foreach($popularProducts as $product)
                <div class="feature-card">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px; margin-bottom: 20px;">
                    <h3>{{ $product->name }}</h3>
                    <p style="margin-bottom: 15px;">{{ Str::limit($product->description, 80) }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700; color: var(--primary); font-size: 1.2rem;">Rs. {{ number_format($product->price, 0) }}</span>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" class="btn" style="padding: 8px 20px; font-size: 14px;">Add to Cart</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <p>Feedback</p>
                <h2>What Our Customers Say</h2>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <div style="color: var(--primary); margin-bottom: 15px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The best sourdough in the city! I come here every weekend for my fresh loaf. The crust is perfect every single time."</p>
                    <div class="customer">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Rahul" class="customer-img">
                        <div>
                            <div class="customer-name">Rahul Sharma</div>
                            <div>Bread Enthusiast</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div style="color: var(--primary); margin-bottom: 15px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Ordered a custom cake for my daughter's birthday. Not only was it beautiful, but it was also the most delicious cake we've ever had."</p>
                    <div class="customer">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Priya" class="customer-img">
                        <div>
                            <div class="customer-name">Priya Thapa</div>
                            <div>Happy Mother</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div style="color: var(--primary); margin-bottom: 15px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The coffee and croissant combo is my go-to breakfast now. Fresh, delicious, and great value for money."</p>
                    <div class="customer">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Ananya" class="customer-img">
                        <div>
                            <div class="customer-name">Ananya Reddy</div>
                            <div>Breakfast Lover</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
