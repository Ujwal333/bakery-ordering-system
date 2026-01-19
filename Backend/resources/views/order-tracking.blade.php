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
                        <div class="status-item">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Order Placed</h4>
                                <p>We've received your order and it's being processed.</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Preparing</h4>
                                <p>Our bakers are crafting your order with love.</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Ready for Handover</h4>
                                <p>Your order is prepared and ready at our counter.</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-dot"></div>
                            <div class="status-info">
                                <h4>Handed to Courier</h4>
                                <p>Successfully handed over to our logistic partner.</p>
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

                    <div id="tracking-actions" style="margin-top: 30px; text-align: center; display: none;">
                        <button id="btn-cancel-tracked" class="track-btn" style="background: #dc3545; max-width: 250px;">Cancel Order</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Auto-fill order ID from URL or session storage
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const orderIdFromUrl = urlParams.get('order');
            const orderIdFromSession = sessionStorage.getItem('pendingOrderId');
            
            if (orderIdFromUrl) {
                document.getElementById('order-id').value = orderIdFromUrl;
            } else if (orderIdFromSession) {
                document.getElementById('order-id').value = orderIdFromSession;
                sessionStorage.removeItem('pendingOrderId');
            }
        });

        document.getElementById('tracking-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const orderId = document.getElementById('order-id').value;
            const phone = document.getElementById('phone').value;
            const btn = document.querySelector('.track-btn');
            
            btn.textContent = 'Searching...';
            btn.disabled = true;

            try {
                const response = await fetch('/api/track-order?order_id=' + encodeURIComponent(orderId) + '&phone=' + encodeURIComponent(phone));
                const data = await response.json();

                if (response.ok && data.success) {
                    const resultArea = document.getElementById('tracking-result');
                    resultArea.style.display = 'block';
                    
                    document.getElementById('result-order-id').textContent = `Order ${data.order.order_number}`;
                    document.getElementById('result-order-date').textContent = `Placed on ${new Date(data.order.created_at).toLocaleDateString()}`;
                    
                    // Update Timeline
                    const status = data.order.status; 
                    const steps = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
                    const uiSteps = document.querySelectorAll('.status-item');
                    
                    let activeFound = false;
                    // Simple logic: map status to index. 
                    // pending=0, confirmed=1, preparing=1, out_for_delivery=2, delivered=3
                    // This needs to match your timeline HTML structure.
                    // For now, let's just activate based on text match or simple progression.
                    
                    uiSteps.forEach(step => {
                        step.classList.remove('active', 'completed');
                        // Reset
                    });

                    // Highlight logic (6 steps: Order Placed, Preparing, Ready, Handover, Out for Delivery, Delivered)
                    if (status === 'delivered') {
                        uiSteps.forEach(s => s.classList.add('completed'));
                    } else if (status === 'out_for_delivery') {
                         for(let i=0; i<4; i++) uiSteps[i].classList.add('completed');
                         uiSteps[4].classList.add('active');
                    } else if (status === 'with_logistic') {
                         for(let i=0; i<3; i++) uiSteps[i].classList.add('completed');
                         uiSteps[3].classList.add('active');
                    } else if (status === 'ready') {
                         for(let i=0; i<2; i++) uiSteps[i].classList.add('completed');
                         uiSteps[2].classList.add('active');
                    } else if (['preparing', 'confirmed'].includes(status)) {
                         uiSteps[0].classList.add('completed');
                         uiSteps[1].classList.add('active');
                    } else {
                        // Pending
                        uiSteps[0].classList.add('active');
                    }

                    // Cancellation option
                    const cancelBtnArea = document.getElementById('tracking-actions');
                    const cancelBtn = document.getElementById('btn-cancel-tracked');
                    if (['pending', 'confirmed'].includes(status)) {
                        cancelBtnArea.style.display = 'block';
                        cancelBtn.onclick = () => cancelTrackedOrder(data.order.id);
                    } else {
                        cancelBtnArea.style.display = 'none';
                    }
                    
                    resultArea.scrollIntoView({ behavior: 'smooth' });
                    showNotification('Order found!', 'success');
                } else {
                    showNotification(data.message || 'Order not found.', 'error');
                }
            } catch (err) {
                console.error(err);
                showNotification('Error tracking order.', 'error');
            } finally {
                btn.textContent = 'Track Order';
                btn.disabled = false;
            }
        });

        async function cancelTrackedOrder(orderId) {
            if (!confirm('Are you sure you want to cancel this order?')) return;
            
            try {
                const response = await fetch(`/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    showNotification(data.message);
                    location.reload();
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (e) {
                console.error(e);
                showNotification('An error occurred.', 'error');
            }
        }
    </script>
@endsection
