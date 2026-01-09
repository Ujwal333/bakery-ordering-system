@extends('layouts.app')

@section('title', 'Order Tracking - Cinnamon Bakery')

@section('styles')
    <style>
        .tracking-section {
            padding: 80px 0;
            min-height: 70vh;
            background: var(--light);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .tracking-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        .track-btn {
            width: 100%;
            background: var(--accent);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .track-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        /* Tracking Results */
        .tracking-result {
            display: none;
            margin-top: 40px;
            border-top: 2px solid #eee;
            padding-top: 40px;
        }

        .status-timeline {
            margin-top: 30px;
            position: relative;
        }

        .status-timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            height: 100%;
            width: 2px;
            background: #eee;
        }

        .status-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 30px;
        }

        .status-dot {
            position: absolute;
            left: 11px;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #eee;
            border: 4px solid white;
            box-shadow: 0 0 0 2px #eee;
            z-index: 2;
        }

        .status-item.active .status-dot {
            background: var(--accent);
            box-shadow: 0 0 0 2px var(--accent);
        }

        .status-item.completed .status-dot {
            background: #4CAF50;
            box-shadow: 0 0 0 2px #4CAF50;
        }

        .status-info h4 {
            font-size: 18px;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .status-info p {
            font-size: 14px;
            color: #777;
        }
    </style>
@endsection

@section('content')
    <section class="tracking-section">
        <div class="container">
            <div class="section-title">
                <h2>Track Your Order</h2>
                <p>Enter your order details below to see the current status of your delicious treats!</p>
            </div>

            <div class="tracking-container">
                <form id="tracking-form">
                    <div class="form-group">
                        <label for="order-id">Order ID</label>
                        <input type="text" id="order-id" class="form-control" placeholder="e.g., #CB-12345" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <button type="submit" class="track-btn">Track Order</button>
                </form>

                <div class="tracking-result" id="tracking-result">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <h3 id="result-order-id" style="color: var(--secondary);">Order #CB-12345</h3>
                        <p id="result-order-date">Placed on Oct 24, 2023</p>
                    </div>

                    <div class="status-timeline">
                        <div class="status-item completed">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Order Placed</h4>
                                <p>We've received your order and it's being processed.</p>
                            </div>
                        </div>
                        <div class="status-item active">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Preparing</h4>
                                <p>Our bakers are crafting your order with love.</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Out for Delivery</h4>
                                <p>Your order is on the way to your doorstep.</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Delivered</h4>
                                <p>Enjoy your fresh treats from Cinnamon Bakery!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.getElementById('tracking-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const orderId = document.getElementById('order-id').value;
            const phone = document.getElementById('phone').value;
            
            // Show result area (dummy data for now)
            const resultArea = document.getElementById('tracking-result');
            if (resultArea) {
                resultArea.style.display = 'block';
                document.getElementById('result-order-id').textContent = `Order ${orderId}`;
                
                // Smooth scroll to results
                resultArea.scrollIntoView({ behavior: 'smooth' });
                showNotification('Order status retrieved successfully!');
            }
        });
    </script>
@endsection
