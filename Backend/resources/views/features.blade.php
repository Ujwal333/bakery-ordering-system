@extends('layouts.app')

@section('title', 'Cinnamon Bakery - Features')

@section('styles')
    <style>
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

        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15); }
        .feature-img { height: 200px; background-size: cover; background-position: center; }
        .feature-content { padding: 30px; flex-grow: 1; }
        .feature-icon { font-size: 2.5rem; color: var(--primary); margin-bottom: 20px; }
        .feature-content h3 { font-size: 1.6rem; color: var(--secondary); margin-bottom: 15px; }
        .feature-benefits { background: var(--light); padding: 15px; border-radius: 8px; margin-top: 15px; }
        .feature-benefits h4 { font-size: 1.1rem; color: var(--secondary); margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .feature-benefits ul { list-style: none; padding-left: 20px; }
        .feature-benefits li { margin-bottom: 8px; position: relative; padding-left: 25px; }
        .feature-benefits li:before { content: '\f00c'; font-family: 'Font Awesome 5 Free'; font-weight: 900; position: absolute; left: 0; top: 2px; color: var(--accent); }

        /* Gallery Section */
        .gallery-section { background: linear-gradient(to right, var(--light) 50%, white 50%); padding: 80px 0; margin-top: 60px; }
        .gallery-container { display: flex; gap: 40px; align-items: center; }
        .gallery-content { flex: 1; }
        .gallery-content h2 { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary); margin-bottom: 20px; }
        .gallery-images { flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .gallery-item { border-radius: 10px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); aspect-ratio: 1/1; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        @media (max-width: 992px) { .gallery-container { flex-direction: column; } }
    </style>
@endsection

@section('content')
    <!-- Features Intro -->
    <section class="features-intro" style="margin-top: 60px;">
        <div class="container">
            <h2>Our Sweet Features</h2>
            <p>Discover all the ways we make your experience with Cinnamon Bakery delightful, convenient, and memorable.</p>
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
                        <div class="feature-icon"><i class="fas fa-shopping-cart"></i></div>
                        <h3>Easy Online Ordering</h3>
                        <p>Browse our menu, customize your order, and checkout in minutes.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits:</h4>
                            <ul>
                                <li>Simple 3-step process</li>
                                <li>Save favorite items</li>
                                <li>Real-time availability</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1594041680534-e8c8cdebd659?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <h3>Live Order Tracking</h3>
                        <p>Follow your order from our bakery to your doorstep in real-time.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits:</h4>
                            <ul>
                                <li>Real-time GPS tracking</li>
                                <li>Arrival notifications</li>
                                <li>Driver contact info</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-img" style="background-image: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="feature-content">
                        <div class="feature-icon"><i class="fas fa-paint-brush"></i></div>
                        <h3>Custom Cake Builder</h3>
                        <p>Design your dream cake with our interactive tool.</p>
                        <div class="feature-benefits">
                            <h4><i class="fas fa-check-circle"></i> Benefits:</h4>
                            <ul>
                                <li>Real-time preview</li>
                                <li>Flavour combinations</li>
                                <li>Instant pricing</li>
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
                    <p>Explore our collection of signature creations and customer favorites.</p>
                    <button class="btn">View Full Gallery</button>
                </div>
                <div class="gallery-images">
                    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1558312651-7d0c7c2d1b13?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Cake"></div>
                    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Cupcakes"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
