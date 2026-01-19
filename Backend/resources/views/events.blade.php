@extends('layouts.app')

@section('title', 'Events - Cinnamon Bakery')

@section('styles')
    <style>
        .events-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1530103043960-ef38714abb15?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 60px;
        }
        .events-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 10px;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }
        .event-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid rgba(212, 167, 106, 0.1);
        }
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(212, 167, 106, 0.15);
        }
        .event-image {
            height: 240px;
            width: 100%;
            object-fit: cover;
        }
        .event-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .event-date {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
            width: fit-content;
        }
        .event-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--secondary);
            margin-bottom: 12px;
        }
        .event-description {
            color: #666;
            line-height: 1.7;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .no-events {
            text-align: center;
            padding: 100px 0;
            color: #888;
        }
        .no-events i {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 20px;
            opacity: 0.5;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
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
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
            display: inline-block;
            text-align: center;
        }
        .btn-view-details:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <section class="events-hero">
        <div class="container">
            <h1>Upcoming Events</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Join us for workshops, tastings, and bakery celebrations!</p>
        </div>
    </section>

    <div class="container">
        @if($events->count() > 0)
            <div class="events-grid">
                @foreach($events as $event)
                    <div class="event-card">
                        @if($event->image_path)
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="event-image">
                        @else
                            <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Placeholder" class="event-image">
                        @endif
                        <div class="event-content">
                            <span class="event-date">
                                <i class="far fa-calendar-alt" style="margin-right: 5px;"></i>
                                {{ $event->event_date->format('F d, Y') }}
                            </span>
                            <h2 style="margin-bottom: 5px;">{{ $event->title }}</h2>
                            <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                            
                            <div class="event-full-desc" style="display:none;">{{ $event->description }}</div>

                            <button class="btn-view-details event-trigger" 
                                data-title="{{ $event->title }}" 
                                data-date="{{ $event->event_date->format('F d, Y') }}" 
                                data-image="{{ $event->image_path ? asset('storage/' . $event->image_path) : 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}">
                                View Details
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-container">
                {{ $events->links() }}
            </div>
        @else
            <div class="no-events">
                <i class="fas fa-calendar-times"></i>
                <h2>No Upcoming Events</h2>
                <p>We're currently planning some exciting new events. Please check back later!</p>
                <a href="{{ route('home') }}" class="btn" style="margin-top: 20px;">Back to Home</a>
            </div>
        @endif
    </div>
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
        });
    </script>
@endsection
