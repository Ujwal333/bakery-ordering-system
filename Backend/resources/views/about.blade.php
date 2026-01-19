@extends('layouts.app')

@section('title', 'About - Cinnamon Bakery')

@section('styles')
    <style>
        .hero-section {
            background: url('https://images.unsplash.com/photo-1608190003443-86b2636f2fe3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
            height: 300px;
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
            background: transparent;
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
        .event-card:hover { transform: translateY(-5px); }
        .event-card h3 { font-size: 1.4rem; color: var(--secondary); margin-bottom: 10px; }
        .event-date { display: inline-block; background: var(--primary); color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.9rem; margin-bottom: 15px; }
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
            background: rgba(212, 165, 110, 0.85);
        }
        .quote-content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .quote-content h3 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 20px; }
        .quote-content p { font-size: 1.2rem; font-style: italic; line-height: 1.8; }
        @media (max-width: 992px) { .about-container { flex-direction: column; } .hero-content h1 { font-size: 3rem; } }
        @media (max-width: 768px) { .hero-section { height: 300px; } .hero-content h1 { font-size: 2.5rem; } .about-content, .events-content { padding: 25px; } }

        /* Original Help Center Styles Restored */
        .help-center {
            padding: 80px 0;
            background: #fff;
        }
        .faq-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 50px;
        }
        .faq-item {
            background: #fdf1e6;
            padding: 30px;
            border-radius: 20px;
            border-left: 5px solid var(--primary);
            transition: transform 0.3s ease;
        }
        .faq-item:hover {
            transform: translateY(-5px);
        }
        .faq-item h3 {
            font-family: 'Playfair Display', serif;
            color: var(--secondary);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        .faq-item p {
            color: #666;
            line-height: 1.6;
            font-size: 1rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: white;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: modalSlide 0.3s ease-out;
            position: relative;
        }
        @keyframes modalSlide {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .modal-header {
            position: relative;
            height: 250px;
        }
        .modal-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            color: white;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            z-index: 10;
        }
        .modal-body {
            padding: 30px;
        }
        .modal-body h2 {
            font-family: 'Playfair Display', serif;
            color: var(--secondary);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        .modal-date {
            color: var(--primary);
            font-weight: 600;
            display: block;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .modal-desc {
            color: #555;
            line-height: 1.8;
            font-size: 1.05rem;
            white-space: pre-line;
        }
        .btn-view-details {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
            display: inline-block;
        }
        .btn-view-details:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        /* Features Section Styles */
        .features-section {
            padding: 80px 0;
            background: white;
        }
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
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }
        .feature-card {
            background: #fffaf5;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(123, 63, 0, 0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0e6dc;
        }
        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(123, 63, 0, 0.1); }
        .feature-img { height: 200px; background-size: cover; background-position: center; }
        .feature-content { padding: 30px; flex-grow: 1; }
        .feature-icon { font-size: 2.5rem; color: var(--primary); margin-bottom: 20px; }
        .feature-content h3 { font-size: 1.6rem; color: var(--secondary); margin-bottom: 15px; }
        .feature-benefits { background: white; padding: 15px; border-radius: 8px; margin-top: 15px; border: 1px dashed #d4a76a; }
        .feature-benefits h4 { font-size: 1.1rem; color: var(--secondary); margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .feature-benefits ul { list-style: none; padding-left: 5px; }
        .feature-benefits li { margin-bottom: 8px; position: relative; padding-left: 25px; font-size: 0.95rem; }
        .feature-benefits li:before { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; left: 0; top: 2px; color: var(--primary); }

        /* Gallery Section Styles */
        .page-gallery {
            padding: 80px 0;
            background: #fdf1e6;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        .gallery-item-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(123, 63, 0, 0.08);
            transition: all 0.3s ease;
        }
        .gallery-item-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(123, 63, 0, 0.15);
        }
        .gallery-item-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .gallery-item-info {
            padding: 20px;
        }
        .gallery-item-info h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--secondary);
            margin-bottom: 10px;
        }
        .gallery-item-info p {
            color: #666;
            font-size: 0.9rem;
        }
        .gallery-category {
            display: inline-block;
            padding: 5px 15px;
            background: var(--light);
            color: var(--secondary);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
        }

        /* Vertical Sub-Navigation Styles */
        .about-page-layout {
            display: flex;
            gap: 25px;
            margin-top: 30px;
            position: relative;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }
        .page-sidebar {
            width: 200px;
            flex-shrink: 0;
        }
        .page-sub-nav {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 90px;
            z-index: 10;
            border: 1px solid #f0e6dc;
        }
        .sub-nav-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sub-nav-list a {
            text-decoration: none;
            color: var(--secondary);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            display: block;
            padding: 8px 12px;
            border-radius: 6px;
            background: #fff;
        }
        .sub-nav-list a:hover {
            color: var(--primary);
            background: #fdf1e6;
            transform: translateX(5px);
        }
        .sub-nav-list li.active a {
            background: var(--primary);
            color: white;
        }

        .about-main-content {
            flex: 1;
            min-width: 0;
        }

        @media (max-width: 992px) {
            .about-page-layout { flex-direction: column; }
            .page-sidebar { width: 100%; }
            .page-sub-nav { position: static; }
            .sub-nav-list { flex-direction: row; flex-wrap: wrap; justify-content: center; }
        }

        /* Lightbox Styles */
        .lightbox-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .lightbox-content {
            max-width: 90%;
            max-height: 80%;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }
        .lightbox-caption {
            color: white;
            margin-top: 20px;
            text-align: center;
            font-size: 1.2rem;
            font-family: 'Playfair Display', serif;
        }
        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 40px;
            color: white;
            font-size: 40px;
            cursor: pointer;
            transition: 0.3s;
        }
        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 40px;
            cursor: pointer;
            padding: 20px;
            user-select: none;
            transition: 0.3s;
        }
        .lightbox-prev { left: 20px; }
        .lightbox-next { right: 20px; }
        .lightbox-nav:hover { color: var(--primary); }

        .gallery-item-card {
            cursor: pointer;
        }
        .gallery-item-card .img-container {
            position: relative;
            overflow: hidden;
        }
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(123, 63, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
            color: white;
            font-size: 2rem;
        }
        .gallery-item-card:hover .gallery-overlay {
            opacity: 1;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" id="about-us">
        <div class="hero-content">
            <h1>About</h1>
        </div>
    </section>

    <!-- Layout Wrapper -->
    <div class="container about-page-layout">
        <!-- Vertical Sub-Navigation -->
        <aside class="page-sidebar">
            <nav class="page-sub-nav">
                <ul class="sub-nav-list">
                    <li><a href="#about-us"><i class="fas fa-info-circle" style="margin-right: 10px;"></i> About Us</a></li>
                    <li><a href="#events-section"><i class="fas fa-calendar-alt" style="margin-right: 10px;"></i> Upcoming Events</a></li>
                    <li><a href="#features"><i class="fas fa-star" style="margin-right: 10px;"></i> Features</a></li>
                    <li><a href="#gallery"><i class="fas fa-images" style="margin-right: 10px;"></i> Gallery</a></li>
                    <li><a href="#help-section"><i class="fas fa-question-circle" style="margin-right: 10px;"></i> Help Center</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="about-main-content">
            <!-- About Section -->
            <div class="about-content" style="margin-bottom: 60px; width: 100%;">
                <h2>{{ $pageContents->get('main')->title ?? 'About' }}</h2>
                <p>{{ $pageContents->get('main')->content ?? "Welcome to Cinnamon Bakery! Established in 2022, we've been crafting delicious treats with love and the finest ingredients. Our passion for baking shines through in every cake, pastry, and loaf we make." }}</p>

                @if($pageContents->get('main') && $pageContents->get('main')->image_path)
                    <div class="about-image" style="background: url('{{ asset('storage/' . $pageContents->get('main')->image_path) }}') no-repeat center center; background-size: cover;"></div>
                @else
                    <div class="about-image" style="background: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') no-repeat center center; background-size: cover;"></div>
                @endif
                
                <p>We specialize in traditional baking methods using premium ingredients to create exceptional baked goods that cater to all tastes. From our signature cinnamon rolls to custom celebration cakes, every item is made with attention to detail and a commitment to quality.</p>
                
                <a href="#gallery" class="btn" style="margin-top: 20px;">View Our Gallery</a>
            </div>

            <!-- Events Section -->
            <div class="events-content" id="events-section" style="margin-bottom: 60px; width: 100%;">
                <h2>Upcoming Events</h2>
                <div class="gallery-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                    @forelse($events as $event)
                        <div class="event-card">
                            @if($event->image_path)
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width:100%; height: 200px; object-fit: cover; border-radius:8px; margin-bottom:15px;">
                            @else
                                <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder" style="width:100%; height: 200px; object-fit: cover; border-radius:8px; margin-bottom:15px;">
                            @endif
                            <span class="event-date">{{ $event->event_date->format('F d, Y') }}</span>
                            <h3 style="margin-top: 10px;">{{ $event->title }}</h3>
                            <p style="color: #666; font-size: 0.95rem; margin-bottom: 15px;">{{ Str::limit($event->description, 80) }}</p>
                            
                            <div class="event-full-desc" style="display:none;">{{ $event->description }}</div>
                            
                            <button class="btn-view-details event-trigger" 
                                data-title="{{ $event->title }}" 
                                data-date="{{ $event->event_date->format('F d, Y') }}" 
                                data-image="{{ $event->image_path ? asset('storage/' . $event->image_path) : 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}">
                                View Event Details
                            </button>
                        </div>
                    @empty
                        <div class="event-card" style="text-align: center; color: #666; grid-column: 1 / -1;">
                            <i class="fas fa-calendar-times" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                            <p>No upcoming events at the moment. Check back soon!</p>
                        </div>
                    @endforelse
                </div>
            </div>


    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="features-intro">
                <h2>Our Sweet Features</h2>
                <p>Discover all the ways we make your experience with Cinnamon Bakery delightful, convenient, and memorable.</p>
            </div>
            
            <div class="features-grid">
                @forelse($features as $feature)
                <div class="feature-card">
                    @if($feature->image_path)
                    <div class="feature-img" style="background-image: url('{{ asset('storage/' . $feature->image_path) }}');"></div>
                    @endif
                    <div class="feature-content">
                        @if($feature->icon)
                        <div class="feature-icon"><i class="{{ $feature->icon }}"></i></div>
                        @endif
                        <h3>{{ $feature->title }}</h3>
                        <p>{{ $feature->description }}</p>
                        @if($feature->benefits && count($feature->benefits) > 0)
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits:</h4>
                            <ul>
                                @foreach($feature->benefits as $benefit)
                                <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="feature-card">
                    <div class="feature-content" style="text-align: center;">
                        <p>No features listed yet.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="page-gallery" id="gallery">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--secondary);">Our Gallery</h2>
                <p style="color: #666; font-size: 1.1rem; margin-top: 10px; margin-bottom: 25px;">Explore our delicious creations and sweet masterpieces.</p>
                <button id="viewGalleryBtn" class="btn btn-primary" style="padding: 10px 25px; border-radius: 30px;">View All Images</button>
            </div>

            <div class="gallery-grid">
                @forelse($galleries as $gallery)
                <div class="gallery-item-card gallery-trigger" data-img="{{ asset('storage/' . $gallery->image_path) }}" data-title="{{ $gallery->title }}">
                    <div class="img-container">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}">
                        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                    </div>
                    <div class="gallery-item-info">
                        <h3>{{ $gallery->title }}</h3>
                        @if($gallery->description)
                        <p>{{ $gallery->description }}</p>
                        @endif
                        @if($gallery->category)
                        <span class="gallery-category">{{ ucfirst($gallery->category) }}</span>
                        @endif
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <i class="fas fa-images" style="font-size: 4rem; color: var(--primary); margin-bottom: 20px;"></i>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--secondary); margin-bottom: 10px;">No Images Yet</h3>
                    <p style="color: #666;">Our gallery is being updated. Check back soon!</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Help Center Section (Restored Original Style) -->
        <section class="help-center" id="help-section">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--secondary);">Help Center</h2>
                <div style="height: 4px; width: 80px; background: var(--primary); margin: 20px auto;"></div>
                <p style="color: #666; font-size: 1.1rem; margin-top: 10px;">Find quick answers to your questions about Cinnamon Bakery.</p>
            </div>

            <div class="faq-grid">
                <div class="faq-item">
                    <h3>How do I place an order?</h3>
                    <p>You can browse our menu, add your favorites to the cart, and proceed to checkout. For custom cakes, use our "Designer" feature to specify your preferences.</p>
                </div>
                <div class="faq-item">
                    <h3>What are the delivery charges?</h3>
                    <p>We charge a flat rate of Rs 50 within the Kathmandu Valley. Special or urgent deliveries may have additional fees which will be shown at checkout.</p>
                </div>
                <div class="faq-item">
                    <h3>How can I pay for my order?</h3>
                    <p>We accept Cash on Delivery (COD), eSewa, and Khalti for all online orders. Online payments are processed through safe and secure official gateways.</p>
                </div>
                <div class="faq-item">
                    <h3>What is the lead time for custom cakes?</h3>
                    <p>We recommend ordering custom cakes at least 48 hours in advance. For complex wedding or large event cakes, please contact us 1-2 weeks early.</p>
                </div>
                <div class="faq-item">
                    <h3>Can I track my delivery?</h3>
                    <p>Yes! Once your order is confirmed, you can use the "Track Order" feature in your profile or use the tracking ID provided in your account dashboard.</p>
                </div>
                <div class="faq-item">
                    <h3>Do you offer eggless options?</h3>
                    <p>Many of our products can be made eggless upon request. Please specify this in the "Special Instructions" box during checkout or while designing a custom cake.</p>
                </div>
            </div>
        </section>

        <!-- Event Detail Modal Placeholder -->
    </div> <!-- Close .about-main-content -->
</div> <!-- Close .about-page-layout -->

    <!-- Lightbox Modal -->
    <div id="lightboxModal" class="lightbox-modal">
        <span class="lightbox-close">&times;</span>
        <span class="lightbox-nav lightbox-prev"><i class="fas fa-chevron-left"></i></span>
        <img class="lightbox-content" id="lightboxImg">
        <div class="lightbox-caption" id="lightboxCaption"></div>
        <span class="lightbox-nav lightbox-next"><i class="fas fa-chevron-right"></i></span>
    </div>

    <!-- Event Detail Modal -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <img id="modalImage" src="" alt="Event Image">
            </div>
            <div class="modal-body">
                <span id="modalDate" class="modal-date"></span>
                <h2 id="modalTitle"></h2>
                <p id="modalDesc" class="modal-desc"></p>
            </div>
        </div>
    </div>

    <!-- Quote Section -->
    <section class="quote-section">
        <div class="quote-content">
            <h3>{{ $pageContents->get('quote')->title ?? 'Cinnamon Bakery' }}</h3>
            <p>{{ $pageContents->get('quote')->content ?? 'A collection of traditions passed down through generations. Our passion is creating sweet moments that bring people together.' }}</p>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('eventModal');
            const triggers = document.querySelectorAll('.event-trigger');
            const closeBtn = document.querySelector('.close-modal');

            triggers.forEach(trigger => {
                trigger.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    const date = this.getAttribute('data-date');
                    const image = this.getAttribute('data-image');
                    const desc = this.closest('.event-card').querySelector('.event-full-desc').innerHTML;

                    document.getElementById('modalTitle').innerText = title;
                    document.getElementById('modalDate').innerText = date;
                    document.getElementById('modalDesc').innerHTML = desc;
                    document.getElementById('modalImage').src = image;

                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            });

            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });

            // Lightbox functionality
            const lightbox = document.getElementById('lightboxModal');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxCaption = document.getElementById('lightboxCaption');
            const lightboxTriggers = document.querySelectorAll('.gallery-trigger');
            const lightboxClose = document.querySelector('.lightbox-close');
            const lightboxPrev = document.querySelector('.lightbox-prev');
            const lightboxNext = document.querySelector('.lightbox-next');
            let currentIdx = 0;

            function openLightbox(idx) {
                currentIdx = idx;
                const trigger = lightboxTriggers[currentIdx];
                lightboxImg.src = trigger.dataset.img;
                lightboxCaption.innerText = trigger.dataset.title;
                lightbox.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            lightboxTriggers.forEach((trigger, idx) => {
                trigger.addEventListener('click', () => openLightbox(idx));
            });

            const viewGalleryBtn = document.getElementById('viewGalleryBtn');
            if(viewGalleryBtn && lightboxTriggers.length > 0) {
                viewGalleryBtn.addEventListener('click', () => openLightbox(0));
            }

            lightboxClose.addEventListener('click', () => {
                lightbox.style.display = 'none';
                document.body.style.overflow = 'auto';
            });

            lightboxPrev.addEventListener('click', (e) => {
                e.stopPropagation();
                let idx = currentIdx - 1;
                if (idx < 0) idx = lightboxTriggers.length - 1;
                openLightbox(idx);
            });

            lightboxNext.addEventListener('click', (e) => {
                e.stopPropagation();
                let idx = currentIdx + 1;
                if (idx >= lightboxTriggers.length) idx = 0;
                openLightbox(idx);
            });

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    lightbox.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
@endsection
