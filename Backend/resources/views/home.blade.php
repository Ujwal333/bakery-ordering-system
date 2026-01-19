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

        /* Updated Premium Home Styles */
        body { background: #fdf1e6 !important; }
        
        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            color: var(--secondary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .section-title p {
            color: #d4a76a;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 14px;
        }

        .popular-card {
            background: white;
            padding: 30px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(123, 63, 0, 0.05);
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .popular-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(123, 63, 0, 0.1);
        }

        .popular-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 25px;
            background: #fdf1e6;
        }

        .popular-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            color: var(--secondary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .popular-card .desc {
            color: #8d6e63;
            font-size: 15px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .popular-card .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-top: auto;
        }

        .popular-card .price-col {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1.2;
        }

        .popular-card .price {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
        }

        .popular-card .old-price {
            font-size: 14px;
            color: #8d6e63;
            text-decoration: line-through;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .popular-card .add-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .popular-card .add-btn:hover {
            background: #e68a00;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .section-title h2 { font-size: 32px; }
        }
    </style>
@endsection

@section('content')
    <!-- Main Title -->
    <div class="container" style="margin-top: 30px; text-align: center;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary); font-weight: 700; letter-spacing: 2px; margin-bottom: 0.5em;">CINNAMON BAKERY</h1>
    </div>

    <!-- Hero Section -->
    <section class="hero" style="{{ ($pageContents->get('hero') && $pageContents->get('hero')->image_path) ? 'background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' . asset('storage/' . $pageContents->get('hero')->image_path) . '); background-size: cover; background-position: center;' : '' }}">
        <div class="container hero-content">
            <h1>{{ $pageContents->get('hero')->title ?? 'Artisan Bakery Crafted with Love' }}</h1>
            <p>{{ $pageContents->get('hero')->content ?? 'Discover our handcrafted pastries, cakes, and breads made with premium ingredients' }}</p>
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
                @forelse($features as $feature)
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="{{ $feature->icon }}"></i>
                    </div>
                    <h3>{{ $feature->title }}</h3>
                    <p>{{ $feature->description }}</p>
                </div>
                @empty
                <!-- Fallback Features -->
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
                @endforelse
            </div>
        </div>
    </section>

    <!-- Best Sellers -->
    <section id="menu" style="padding: 100px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Our Best Sellers</h2>
            </div>
            <div class="testimonial-grid">
                @foreach($popularProducts as $product)
                <div class="popular-card" style="position: relative;">
                    @if($product->is_popular)
                        <div style="position: absolute; top: 10px; right: 10px; background: var(--secondary); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; z-index: 10;">BEST SELLER</div>
                    @endif
                    <img src="{{ (Str::startsWith($product->image_url, 'http') || Str::startsWith($product->image_url, '/storage')) ? $product->image_url : '/storage/' . $product->image_url }}" alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p class="desc">{{ Str::limit($product->description, 80) }}</p>
                    <div class="price-row">
                        <div class="price-col">
                            @if($product->discount_price > 0)
                                <span class="old-price">Rs. {{ number_format($product->price, 0) }}</span>
                                <span class="price">Rs. {{ number_format($product->discount_price, 0) }}</span>
                            @else
                                <span class="price">Rs. {{ number_format($product->price, 0) }}</span>
                            @endif
                        </div>
                        @php
                            $finalPrice = $product->discount_price > 0 ? $product->discount_price : $product->price;
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                            @if($product->stock <= 0)
                                <span style="color: #dc3545; font-size: 11px; font-weight: 600;">Out of Stock</span>
                                <button class="add-btn" disabled style="background: #ccc; cursor: not-allowed; opacity: 0.7;">Add to Cart</button>
                            @else
                                @if($product->stock < 5)
                                    <span style="color: #e67e22; font-size: 10px; font-weight: 600;">Only {{ $product->stock }} left!</span>
                                @endif
                                <button class="add-btn" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $finalPrice }})">Add to Cart</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <p>Social Feedback</p>
                <h2>What Our Customers Say</h2>
            </div>
            <div class="testimonial-grid" id="testimonial-list">
                @foreach($testimonials as $testimonial)
                <div class="testimonial-card">
                    <div style="color: var(--primary); margin-bottom: 15px;">
                        @for($i=0; $i<$testimonial->rating; $i++) <i class="fas fa-star"></i> @endfor
                    </div>
                    <p class="testimonial-text">"{{ $testimonial->content }}"</p>
                    <div class="customer">
                        <div class="initials-circle">{{ substr($testimonial->customer_name, 0, 1) }}</div>
                        <div>
                            <div class="customer-name">{{ $testimonial->customer_name }}</div>
                            <div style="font-size: 13px; color: #888;">Verified Customer</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Submit Review Form -->
            <div class="feature-card" style="margin-top: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
                <h3 style="margin-bottom: 20px;">Share Your Experience</h3>
                <form id="review-form">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <select id="rev-rating" class="size-select" style="max-width: 200px;">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                            <option value="2">★★☆☆☆ (2 Stars)</option>
                            <option value="1">★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>
                    <textarea id="rev-content" placeholder="Write your review here..." style="width: 100%; height: 100px; padding: 15px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 15px; font-family: inherit;"></textarea>
                    <button type="submit" class="btn" style="width: 100%;">Submit Review</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Inquiries & Feedback Section -->
    <section id="contact" style="padding: 100px 0; background: white;">
        <div class="container">
            <div class="section-title">
                <p>Have Questions?</p>
                <h2>Inquiries & Feedback</h2>
            </div>
            <div class="features-grid" style="grid-template-columns: 1fr 1.5fr; gap: 40px; align-items: start;">
                <div class="feature-card" style="padding: 30px; text-align: left;">
                    <h3>Contact Information</h3>
                    <p style="margin-bottom: 20px;">Feel free to reach out to us for bulk orders, custom designs, or general feedback.</p>
                    <div style="margin-bottom: 15px;"><i class="fas fa-phone-alt" style="color: var(--primary); margin-right: 15px;"></i> +977 1234567890</div>
                    <div style="margin-bottom: 15px;"><i class="fas fa-envelope" style="color: var(--primary); margin-right: 15px;"></i> info@cinnamonbakery.com</div>
                    <div style="margin-bottom: 15px;"><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 15px;"></i> Kathmandu, Nepal</div>
                </div>

                <div class="feature-card" style="padding: 30px; text-align: left;">
                    <form id="inquiry-form">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <input type="text" id="inq-name" placeholder="Your Name" style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;" required>
                            <input type="email" id="inq-email" placeholder="Email Address" style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;" required>
                        </div>
                        <input type="text" id="inq-subject" placeholder="Subject (Inquiry/Feedback/Report)" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;" required>
                        <textarea id="inq-message" placeholder="Type your message here..." style="width: 100%; height: 120px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; font-family: inherit;" required></textarea>
                        <button type="submit" class="btn" style="width: 100%;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Review Submission
    document.getElementById('review-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const content = document.getElementById('rev-content').value;
        const rating = document.getElementById('rev-rating').value;

        if(!content) return showNotification('Please write something!', 'error');

        try {
            const response = await fetch('/api/reviews', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ content, rating })
            });
            const data = await response.json();
            if(response.ok) {
                showNotification('Thank you! Your review is pending approval.');
                this.reset();
            } else {
                showNotification(data.message || 'Error submitting review', 'error');
                if(response.status === 401) window.location = '/login';
            }
        } catch(e) { console.error(e); }
    });

    // Inquiry/Feedback Submission
    document.getElementById('inquiry-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const data = {
            name: document.getElementById('inq-name').value,
            email: document.getElementById('inq-email').value,
            subject: document.getElementById('inq-subject').value,
            message: document.getElementById('inq-message').value,
        };

        try {
            const response = await fetch('/api/inquiries', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(data)
            });
            if(response.ok) {
                showNotification('Message sent successfully! We will get back to you soon.');
                this.reset();
            } else {
                showNotification('Failed to send message.', 'error');
            }
        } catch(e) { console.error(e); }
    });
</script>
@endsection
