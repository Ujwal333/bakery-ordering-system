@extends('layouts.app')

@section('title', 'Checkout - Cinnamon Bakery')

@section('styles')
    <style>
        .checkout-section { padding: 80px 0; min-height: 70vh; }
        .section-title { text-align: center; margin-bottom: 50px; }
        .section-title h1 { font-family: 'Playfair Display', serif; font-size: 42px; color: var(--secondary); margin-bottom: 10px; }
        .checkout-container { display: grid; grid-template-columns: 1fr 400px; gap: 40px; }
        .checkout-form { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); }
        .form-section { margin-bottom: 30px; }
        .form-section h3 { font-size: 20px; color: var(--secondary); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--accent2); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--secondary); }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 15px; border: 2px solid #e0d6c9; border-radius: 8px; font-size: 16px; background: #f9f3e9; }
        .payment-methods { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 15px; }
        .payment-method { border: 2px solid #e0d6c9; border-radius: 10px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.3s ease; background: #f9f3e9; }
        .payment-method.selected { border-color: var(--primary); background: rgba(212, 167, 106, 0.1); box-shadow: 0 5px 15px rgba(123, 63, 0, 0.1); }
        .order-summary { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); height: fit-content; position: sticky; top: 100px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .summary-item.total { border-top: 2px solid var(--primary); border-bottom: none; padding-top: 15px; font-size: 18px; font-weight: 700; color: var(--secondary); }
        .place-order-btn { display: block; width: 100%; background: linear-gradient(to right, var(--secondary), var(--primary)); color: white; border: none; padding: 16px; border-radius: 10px; font-size: 18px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-top: 20px; }
        @media (max-width: 900px) { .checkout-container { grid-template-columns: 1fr; } .order-summary { position: static; margin-top: 30px; } }
    </style>
@endsection

@section('content')
    <section class="checkout-section">
        <div class="container">
            <div class="section-title">
                <h1>Checkout</h1>
                <p>Complete your order</p>
            </div>

            <div class="checkout-container">
                <div class="checkout-form">
                    <form id="checkout-form">
                        <div class="form-section">
                            <h3>Delivery Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" id="fullname" name="customer_name" required value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="customer_email" required value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="customer_phone" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Delivery Address</label>
                                <textarea id="address" name="delivery_address" required></textarea>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Payment Method</h3>
                            <div class="payment-methods">
                                <div class="payment-method selected" onclick="selectPayment('cod')">
                                    <i class="fas fa-money-bill-wave"></i><br><span>Cash on Delivery</span>
                                </div>
                                <div class="payment-method" onclick="selectPayment('khalti')">
                                    <i class="fas fa-mobile-alt"></i><br><span>Khalti</span>
                                </div>
                            </div>
                            <input type="hidden" name="payment_method" id="payment_method" value="cod">
                        </div>
                    </form>
                </div>

                <div class="order-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    <div id="order-items">Loading...</div>
                    <div style="margin-top:20px; border-top: 1px solid #eee; padding-top:15px;">
                        <div class="summary-item"><span>Subtotal</span><span id="summary-subtotal">Rs 0</span></div>
                        <div class="summary-item"><span>Delivery Fee</span><span id="summary-delivery">Rs 50</span></div>
                        <div class="summary-item total"><span>Total</span><span id="summary-total">Rs 50</span></div>
                    </div>
                    <button class="place-order-btn" id="place-order-btn" onclick="placeOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', fetchCart);

        async function fetchCart() {
            try {
                const response = await fetch('/cart/view');
                const data = await response.json();
                renderSummary(data);
            } catch (err) { console.error(err); }
        }

        function renderSummary(data) {
            const container = document.getElementById('order-items');
            let html = '';
            data.cart.items.forEach(item => {
                html += `<div class="summary-item"><span>${item.quantity}x ${item.item_name}</span><span>Rs ${item.total_price}</span></div>`;
            });
            container.innerHTML = html;
            document.getElementById('summary-subtotal').textContent = `Rs ${data.subtotal}`;
            document.getElementById('summary-total').textContent = `Rs ${parseFloat(data.subtotal) + 50}`;
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            document.getElementById('payment_method').value = method;
        }

        async function placeOrder() {
            const form = document.getElementById('checkout-form');
            if (!form.checkValidity()) return form.reportValidity();
            
            const btn = document.getElementById('place-order-btn');
            btn.disabled = true;
            btn.textContent = 'Processing...';

            // Placeholder for actual order submission
            setTimeout(() => {
                alert('Order request received! Redirecting to tracking...');
                window.location.href = '/order-tracking';
            }, 1500);
        }
    </script>
@endsection
