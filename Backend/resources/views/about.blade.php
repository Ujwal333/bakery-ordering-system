@extends('layouts.app')

@section('title', 'About - Cinnamon Bakery')

@section('styles')
    <style>
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
        .quote-content h3 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 20px; }
        .quote-content p { font-size: 1.2rem; font-style: italic; line-height: 1.8; }
        @media (max-width: 992px) { .about-container { flex-direction: column; } .hero-content h1 { font-size: 3rem; } }
        @media (max-width: 768px) { .hero-section { height: 300px; } .hero-content h1 { font-size: 2.5rem; } .about-content, .events-content { padding: 25px; } }
    </style>
@endsection

@section('content')
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

            <div class="about-image" style="background: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') no-repeat center center; background-size: cover;"></div>
            <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cupcakes" style="width:100%; border-radius:10px; margin-bottom:20px; box-shadow:0 4px 16px rgba(0,0,0,0.08);">
            
            <p>We specialize in traditional baking methods using premium ingredients to create exceptional baked goods that cater to all tastes. From our signature cinnamon rolls to custom celebration cakes, every item is made with attention to detail and a commitment to quality.</p>
        </div>

        <!-- Events Content -->
        <div class="events-content">
            <h2>Events</h2>
            @forelse($events as $event)
                <div class="event-card">
                    @if($event->image_path)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width:100%; border-radius:8px; margin-bottom:15px;">
                    @else
                        <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder" style="width:100%; border-radius:8px; margin-bottom:15px;">
                    @endif
                    <h3>{{ $event->title }}</h3>
                    <span class="event-date">{{ $event->event_date->format('F d, Y') }}</span>
                    <p>{{ $event->description }}</p>
                </div>
            @empty
                <div class="event-card" style="text-align: center; color: #666;">
                    <i class="fas fa-calendar-times" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                    <p>No upcoming events at the moment. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quote Section -->
    <section class="quote-section">
        <div class="quote-content">
            <h3>Cinnamon Bakery</h3>
            <p>A collection of traditions passed down through generations. Our passion is creating sweet moments that bring people together.</p>
        </div>
    </section>
@endsection
