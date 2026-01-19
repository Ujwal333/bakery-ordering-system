@extends('layouts.app')

@section('title', 'Checkout - Cinnamon Bakery')

@section('styles')
<style>
    /* Modern, Clean Checkout Styles */
    .checkout-wrapper {
        background-color: #fcf8f5;
        min-height: 100vh;
        padding-top: 40px;
        padding-bottom: 80px;
    }
    
    .checkout-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #5e4026; /* Dark Brown */
        text-align: center;
        margin-bottom: 40px;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Left Side: Form */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0e6dc;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-icon {
        width: 30px;
        height: 30px;
        background: #d4a56e;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-full {
        width: 100%;
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #666;
        margin-bottom: 8px;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: border-color 0.3s;
        background: #fafafa;
    }
    
    input:focus, select:focus, textarea:focus {
        border-color: #d4a56e;
        outline: none;
        background: white;
    }

    /* Right Side: Summary */
    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-info {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .item-qty-badge {
        background: #eee;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
        color: #555;
    }

    .total-row {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px dashed #ddd;
        display: flex;
        justify-content: space-between;
        font-size: 1.3rem;
        font-weight: 800;
        color: #5e4026;
    }

    .checkout-btn {
        width: 100%;
        background: #d4a56e;
        color: white;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 25px;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .checkout-btn:hover {
        background: #c3945e;
    }
    
    .checkout-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    /* Order Type Selector */
    .order-type-selector {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }
    .order-type-card {
        flex: 1;
        padding: 20px;
        border: 3px solid #e0e0e0;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }
    .order-type-card:hover {
        border-color: #d4a56e;
        background: #fffaf5;
    }
    .order-type-card.active {
        border-color: #d4a56e;
        background: #fffaf5;
        box-shadow: 0 5px 15px rgba(212, 165, 110, 0.2);
    }
    .order-type-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    .table-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-top: 15px;
    }
    .table-btn {
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 600;
    }
    .table-btn:hover:not(:disabled) {
        border-color: #d4a56e;
        background: #fffaf5;
    }
    .table-btn.selected {
        border-color: #d4a56e;
        background: #d4a56e;
        color: white;
    }
    .table-btn:disabled {
        background: #f5f5f5;
        cursor: not-allowed;
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        .summary-card {
            position: static;
            order: -1; /* Show summary first on mobile */
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="checkout-wrapper">
    <h1 class="checkout-title">Secure Checkout</h1>
    
    <div class="checkout-grid">
        <!-- LEFT: Shipping Form -->
        <div class="form-card">
            <form id="checkout-form">
                @csrf
                <input type="hidden" name="delivery_type" id="delivery-type" value="delivery">
                <input type="hidden" name="table_number" id="table-number" value="">
                
                <!-- Order Type Selector -->
                <div class="order-type-selector">
                    <div class="order-type-card active" onclick="selectOrderType('delivery')" id="delivery-option">
                        <div class="order-type-icon">🚚</div>
                        <h3>Delivery</h3>
                        <p style="margin: 0; font-size: 0.9rem; color: #666;">We'll deliver to you</p>
                    </div>
                    <div class="order-type-card" onclick="selectOrderType('dine-in')" id="dinein-option">
                        <div class="order-type-icon">🍽️</div>
                        <h3>Dine-In</h3>
                        <p style="margin: 0; font-size: 0.9rem; color: #666;">Order at your table</p>
                    </div>
                </div>
                
                <!-- Table Selection (Hidden for delivery) -->
                <div id="table-selection" style="display: none; margin-bottom: 30px;">
                    <div class="section-title">
                        <div class="section-icon">🪑</div>
                        <span>Select Your Table</span>
                    </div>
                    <div class="table-grid" id="table-grid">
                        <!-- Tables will be loaded dynamically -->
                    </div>
                    <div id="dine-in-notice" style="background: #fff4e6; padding: 15px; border-radius: 10px; border: 1px solid #ffe8cc; color: #a0522d; margin-top: 15px; font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> <strong>Note:</strong> Pre-payment of at least <strong>Rs. 200</strong> is required for dine-in reservations to confirm your table.
                    </div>
                    <p id="table-message" style="text-align: center; color: #666; margin-top: 10px;"></p>
                </div>
                
                <!-- Section 1: Contact & Address (Show only for delivery) -->
                <div id="delivery-section">
                <div class="section-title">
                    <div class="section-icon">1</div>
                    <span>Details</span>
                </div>
                
                <div class="form-row">
                    <div>
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="98XXXXXXXX" required>
                    </div>
                    <div>
                        <label>Special Instruction </label>
                        <input type="text" name="special_instructions" placeholder="Allergies, design requests, etc.">
                    </div>
                </div>

                <!-- Address fields (Hidden for dine-in) -->
                <div id="delivery-address-section">
                    <div class="form-row">
                        <div>
                            <label>Province</label>
                            <select name="province" required>
                                <option value="Bagmati">Bagmati</option>
                                <option value="Koshi">Koshi</option>
                                <option value="Madhesh">Madhesh</option>
                                <option value="Gandaki">Gandaki</option>
                                <option value="Lumbini">Lumbini</option>
                                <option value="Karnali">Karnali</option>
                                <option value="Sudurpashchim">Sudurpashchim</option>
                            </select>
                        </div>
                        <div>
                            <label>District</label>
                            <input type="text" name="district" placeholder="District (e.g. Kathmandu)" value="Kathmandu" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>City</label>
                            <select name="city" id="city-select" required>
                                <option value="Kathmandu">Kathmandu</option>
                                <option value="Lalitpur">Lalitpur</option>
                                <option value="Bhaktapur">Bhaktapur</option>
                                <option value="Pokhara">Pokhara</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label>Area / Street</label>
                            <input type="text" name="street" placeholder="Street Address" required>
                        </div>
                    </div>

                    <!-- Map / Location Pin -->
                    <div class="form-full" style="background: #f8f1eb; padding: 15px; border-radius: 12px; border: 1px dashed #d4a56e; margin-bottom: 20px;">
                        <label style="color: #5e4026; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-map-marker-alt"></i> Pin Your Location (Optional)
                        </label>
                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <button type="button" onclick="detectLocation()" style="padding: 8px 15px; background: #fff; border: 1px solid #d4a56e; border-radius: 6px; cursor: pointer; color: #5e4026;">
                                <i class="fas fa-crosshairs"></i> Detect Current Location
                            </button>
                            <span id="location-status" style="align-self: center; font-size: 0.9rem; color: #666;"></span>
                        </div>
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">
                    </div>
                </div>

                <!-- Section 2: Payment (Always visible) -->
                <div class="section-title" style="margin-top: 30px;">
                    <div class="section-icon">2</div>
                    <span>Payment Method</span>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                    @foreach($paymentMethods as $method)
                    <label style="flex: 1; min-width: 140px; cursor: pointer; border: 2px solid #eee; padding: 15px; border-radius: 10px; display: flex; flex-direction: column; align-items: center; gap: 10px; text-align: center; transition: all 0.2s;" class="payment-option">
                        <input type="radio" name="payment_method" value="{{ $method->code }}" {{ $loop->first ? 'checked' : '' }} onchange="updatePaymentUI()"> 
                        @if($method->logo_url)
                            <img src="{{ asset('storage/' . $method->logo_url) }}" style="height: 24px; object-fit: contain;">
                        @elseif($method->code == 'cod')
                            <i class="fas fa-wallet" style="font-size: 24px; color: #28a745;"></i>
                        @else
                            <i class="fas fa-credit-card" style="font-size: 24px; color: #555;"></i>
                        @endif
                        <span style="font-weight: 600;" data-original-code="{{ $method->code }}">{{ $method->display_name }}</span>
                    </label>
                    @endforeach
                </div>
                
                <!-- Manual Payment Details Section (Hidden by default) -->
                <div id="manual-payment-section" style="display: none; background: #fbfbfb; padding: 20px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 20px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h4 style="margin: 0 0 10px 0; color: #333;">Scan to Pay</h4>
                        <!-- Dynamic QR handling -->
                        <img id="payment-qr-code" src="" alt="Payment QR" style="width: 150px; height: 150px; border-radius: 8px; border: 1px solid #ddd; padding: 5px; background: white;">
                        <p style="font-size: 0.9rem; color: #666; margin-top: 5px;">Scan with <span id="payment-provider-name"></span> app</p>
                    </div>

                    <div class="form-row">
                        <div class="form-full">
                            <label>Sender Name</label>
                            <input type="text" name="payment_sender_name" id="payment-sender-name" placeholder="Name on eSewa/Khalti account">
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label>Sender Phone</label>
                            <input type="text" name="payment_sender_phone" id="payment-sender-phone" placeholder="98XXXXXXXX">
                        </div>
                        <div>
                            <label>Transaction Code</label>
                            <input type="text" name="payment_transaction_id" id="payment-transaction-id" placeholder="e.g. 7X3K9...">
                        </div>
                    </div>
                </div>

                <div id="payment-note" style="background: #eef9ff; color: #006699; padding: 10px; border-radius: 8px; font-size: 0.9rem; display: none;">
                    <strong>Note:</strong> Your order will be processed after the payment is verified by our admin.
                </div>
                </div>


                <!-- Section 3: Delivery Window -->
                <div class="section-title" style="margin-top: 30px;">
                    <div class="section-icon">3</div>
                    <span>Schedule</span>
                </div>
                
                <div class="form-row">
                    <div>
                        <label>Date</label>
                        <input type="date" name="delivery_date" id="delivery-date" required min="{{ date('Y-m-d') }}" onchange="updateAvailableTimeSlots()">
                    </div>
                    <div>
                        <label>Time</label>
                        <select name="delivery_window" id="delivery-time" required>
                            <option value="">Select time slot</option>
                        </select>
                        <p id="time-slot-message" style="font-size: 0.85rem; color: #666; margin-top: 5px; display: none;"></p>
                    </div>
                </div>


            </form>
        </div>

        <!-- RIGHT: Summary -->
        <div class="summary-card">
            <h3 style="margin-bottom: 20px; font-weight: 700; color: #333;">Order Summary</h3>
            
            <div id="summary-items-list" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                <p style="text-align: center; color: #999;">Loading items...</p>
            </div>

            <div class="price-row">
                <span>Subtotal</span>
                <span id="summary-subtotal">Rs 0.00</span>
            </div>
            <div class="price-row">
                <span>Delivery Fee</span>
                <span id="summary-delivery">Rs 50.00</span>
            </div>
            <div class="price-row" id="cod-row">
                <span>COD Charge</span>
                <span id="summary-cod">Rs 10.00</span>
            </div>
            
            <div class="total-row">
                <span>Total</span>
                <span id="summary-total">Rs 0.00</span>
            </div>

            <button class="checkout-btn" onclick="placeOrder()">Confirm Order</button>
            <div id="error-msg" style="color: red; text-align: center; margin-top: 10px; font-size: 0.9rem; display: none;"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global Cart State
    let cartItems = [];
    let cartSubtotal = 0;
    // Inject dynamic payment methods from controller
    const paymentMethodsData = @json($paymentMethods);

    document.addEventListener('DOMContentLoaded', () => {
        loadCartData();
        
        // Listeners
        document.getElementById('city-select').addEventListener('change', calculateTotal);
        
        // Initialize payment UI state
        updatePaymentUI();
        
        // Initialize time slots for today
        updateAvailableTimeSlots();
    });

    async function loadCartData() {
        try {
            const res = await fetch('/cart/view');
            const data = await res.json();
            
            if(!data.cart || !data.cart.items || data.cart.items.length === 0) {
                // Empty Cart
                document.getElementById('summary-items-list').innerHTML = '<p style="text-align:center;">Your cart is empty.</p>';
                document.querySelector('.checkout-btn').disabled = true;
                return;
            }

            cartItems = data.cart.items;
            
            // Re-calculate subtotal locally to be 100% sure
            cartSubtotal = cartItems.reduce((acc, item) => {
                return acc + (parseFloat(item.total_price) || (parseFloat(item.unit_price) * item.quantity));
            }, 0);

            renderItems();
            calculateTotal();

        } catch (e) {
            console.error(e);
            document.getElementById('error-msg').innerText = "Failed to load cart. Please refresh.";
            document.getElementById('error-msg').style.display = 'block';
        }
    }

    function renderItems() {
        const container = document.getElementById('summary-items-list');
        let html = '';
        
        cartItems.forEach(item => {
            html += `
                <div class="order-item">
                    <div class="item-info">
                        <span class="item-qty-badge">${item.quantity}x</span>
                        <span style="font-weight: 500;">${item.item_name}</span>
                    </div>
                    <span style="font-weight: 600;">Rs ${parseFloat(item.total_price).toFixed(0)}</span>
                </div>
            `;
        });
        
        container.innerHTML = html;
        document.getElementById('summary-subtotal').innerText = 'Rs ' + cartSubtotal.toFixed(2);
    }

    function calculateTotal() {
        const type = document.getElementById('delivery-type').value;
        let deliveryFee = 0;
        let extraCharge = 0;
        
        if (type === 'delivery') {
            deliveryFee = 50;
            const city = document.getElementById('city-select').value;
            if(city === 'Other' || city === 'Pokhara') {
                deliveryFee = 150;
            }
        }

        // Payment Logic
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if(selected) {
            const method = paymentMethodsData.find(m => m.code === selected.value);
            
            // Only apply COD charge if it's NOT dine-in
            if (method && parseFloat(method.extra_charge) > 0 && type !== 'dine-in') {
                if(method.extra_charge_type === 'percentage') {
                    extraCharge = (cartSubtotal * parseFloat(method.extra_charge) / 100);
                } else {
                    extraCharge = parseFloat(method.extra_charge);
                }
                document.getElementById('cod-row').style.display = 'flex';
                const chargeLabel = document.querySelector('#cod-row span:first-child');
                if(chargeLabel) chargeLabel.innerText = method.code === 'cod' ? 'COD Charge' : 'Processing Fee';
            } else {
                document.getElementById('cod-row').style.display = 'none';
            }
        }

        // Update UI
        document.getElementById('summary-delivery').innerText = 'Rs ' + deliveryFee.toFixed(2);
        document.getElementById('summary-cod').innerText = 'Rs ' + extraCharge.toFixed(2);
        
        const total = cartSubtotal + deliveryFee + extraCharge;
        document.getElementById('summary-total').innerText = 'Rs ' + total.toFixed(2);
    }

    function updatePaymentUI() {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if(!selected) return;

        const methodCode = selected.value;
        const method = paymentMethodsData.find(m => m.code === methodCode);

        const manualSection = document.getElementById('manual-payment-section');
        const note = document.getElementById('payment-note');
        const qrImg = document.getElementById('payment-qr-code');
        const providerName = document.getElementById('payment-provider-name');
        
        // Update labels for Dine-In
        const type = document.getElementById('delivery-type').value;
        document.querySelectorAll('.payment-option span').forEach(el => {
            if (el.dataset.originalLabel === undefined) el.dataset.originalLabel = el.innerText;
            if (type === 'dine-in' && el.dataset.originalCode === 'cod') {
                el.innerText = 'Cash at Real-time';
            } else {
                el.innerText = el.dataset.originalLabel;
            }
        });

        // Highlight selection
        document.querySelectorAll('.payment-option').forEach(el => {
            el.style.borderColor = '#eee';
            el.style.background = 'white';
        });
        selected.closest('label').style.borderColor = '#d4a56e';
        selected.closest('label').style.background = '#fffaf0';

        if(method && method.requires_verification) {
            manualSection.style.display = 'block';
            note.style.display = 'block';
            if(providerName) providerName.innerText = method.display_name;
            
            // Dynamic QR Handling
            if(method.qr_code_path) {
                // Use the uploaded QR code
                qrImg.src = "{{ asset('storage') }}/" + method.qr_code_path;
                qrImg.style.display = 'inline-block';
            } else {
                // Hide QR if not provided
                qrImg.style.display = 'none';
            }
            
            // Set fields as required
            if(document.getElementById('payment-sender-name')) document.getElementById('payment-sender-name').required = true;
            if(document.getElementById('payment-sender-phone')) document.getElementById('payment-sender-phone').required = true;
            if(document.getElementById('payment-transaction-id')) document.getElementById('payment-transaction-id').required = true;
            
        } else {
            manualSection.style.display = 'none';
            note.style.display = 'none';
            
            // Remove required
            if(document.getElementById('payment-sender-name')) document.getElementById('payment-sender-name').required = false;
            if(document.getElementById('payment-sender-phone')) document.getElementById('payment-sender-phone').required = false;
            if(document.getElementById('payment-transaction-id')) document.getElementById('payment-transaction-id').required = false;
        }
        calculateTotal();
    }
    
    function detectLocation() {
        const statusEl = document.getElementById('location-status');
        const latInput = document.getElementById('lat');
        const lngInput = document.getElementById('lng');
        const btn = document.querySelector('button[onclick="detectLocation()"]');
        
        if (!navigator.geolocation) {
            statusEl.innerText = "Geolocation not supported.";
            return;
        }
        
        statusEl.innerText = "Locating...";
        statusEl.style.color = "#d4a56e";
        btn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                latInput.value = lat;
                lngInput.value = lng;
                
                statusEl.innerHTML = `<i class="fas fa-check-circle"></i> Found: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                statusEl.style.color = "green";
                btn.disabled = false;
                
                // Show simple map placeholder or link
                const mapDiv = document.getElementById('map-preview');
                mapDiv.style.height = '150px';
                mapDiv.innerHTML = `<iframe width="100%" height="150" frameborder="0" style="border:0; border-radius: 8px;" src="https://maps.google.com/maps?q=${lat},${lng}&z=15&output=embed"></iframe>`;
            },
            (error) => {
                console.error(error);
                statusEl.innerText = "Unable to retrieve location.";
                statusEl.style.color = "red";
                btn.disabled = false;
            }
        );
    }

    async function placeOrder() {
        const btn = document.querySelector('.checkout-btn');
        const errorDiv = document.getElementById('error-msg');
        const form = document.getElementById('checkout-form');
         
        // Validation
        if(!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        btn.disabled = true;
        btn.innerText = "Processing...";
        errorDiv.style.display = 'none';

        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            // Construct payload matching backend expectation
            let payload = {
                ...data,
                special_instructions: data.special_instructions || "App Checkout",
                delivery_time: data.delivery_window
            };

            if (data.delivery_type === 'delivery') {
                payload.delivery_address = `${data.street}, ${data.city}, ${data.district}, ${data.province}`;
                payload.delivery_city = data.city;
                delete payload.table_number;
            } else if (data.delivery_type === 'dine-in') {
                payload.table_number = document.getElementById('table-number').value;
                if (!payload.table_number) {
                    throw new Error("You are currently in Dine-In mode. Please scroll up and pick a Table Number (1-20) from the layout.");
                }
            }

            const res = await fetch('/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await res.json();

            if(res.ok && result.success) {
                 // Redirect to confirmation page with order details
                 const confirmUrl = new URL('/order-confirmation', window.location.origin);
                 confirmUrl.searchParams.set('order_id', result.order.id);
                 confirmUrl.searchParams.set('order_number', result.order_number);
                 confirmUrl.searchParams.set('phone', data.phone);
                 confirmUrl.searchParams.set('payment_method', data.payment_method);
                 confirmUrl.searchParams.set('delivery_date', data.delivery_date);
                 confirmUrl.searchParams.set('total_amount', document.getElementById('summary-total').innerText.replace('Rs ', ''));
                 
                 window.location.href = confirmUrl.toString();
            } else {
                let msg = "";
                if(result.errors) {
                    // Extract only the first error message from the first field that failed
                    const firstFieldErrors = Object.values(result.errors)[0];
                    msg = firstFieldErrors[0];
                } else {
                    msg = result.message || "Order creation failed";
                }
                throw new Error(msg);
            }

        } catch (e) {
            console.error(e);
            errorDiv.innerText = e.message;
            errorDiv.style.display = 'block';
            btn.disabled = false;
            btn.innerText = "Try Again";
        }
    }

    // Time slot validation logic
    function updateAvailableTimeSlots() {
        const dateInput = document.getElementById('delivery-date');
        const timeSelect = document.getElementById('delivery-time');
        const messageEl = document.getElementById('time-slot-message');
        
        if (!dateInput.value) {
            timeSelect.innerHTML = '<option value="">Please select a date first</option>';
            return;
        }
        
        const selectedDate = new Date(dateInput.value + 'T00:00:00');
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        const isToday = selectedDate.getTime() === today.getTime();
        
        // Define time slots with their start and end times
        const timeSlots = [
            { value: '10:00:00', label: 'Morning (10am - 1pm)', startHour: 10, startMin: 0, endHour: 13, endMin: 0 },
            { value: '13:00:00', label: 'Afternoon (1pm - 4pm)', startHour: 13, startMin: 0, endHour: 16, endMin: 0 },
            { value: '16:00:00', label: 'Evening (4pm - 7pm)', startHour: 16, startMin: 0, endHour: 19, endMin: 0 }
        ];
        
        let availableSlots = [];
        let hasAvailableSlots = false;
        
        if (isToday) {
            const now = new Date();
            const currentHour = now.getHours();
            const currentMin = now.getMinutes();
            
            // Calculate current time in minutes since midnight
            const currentTimeInMin = currentHour * 60 + currentMin;
            
            timeSlots.forEach(slot => {
                // Calculate end time in minutes (this is when the slot ends)
                const slotEndTimeInMin = slot.endHour * 60 + slot.endMin;
                
                // Check if current time + 30 minutes is before slot end time
                // User must order at least 30 minutes before the slot ends
                const requiredTimeInMin = currentTimeInMin + 30;
                
                if (requiredTimeInMin <= slotEndTimeInMin) {
                    availableSlots.push(slot);
                    hasAvailableSlots = true;
                }
            });
            
            if (!hasAvailableSlots) {
                messageEl.textContent = 'No time slots available for today. Please select a future date.';
                messageEl.style.color = '#dc3545';
                messageEl.style.display = 'block';
            } else {
                messageEl.textContent = 'Orders must be placed at least 30 minutes before the end of each time slot.';
                messageEl.style.color = '#666';
                messageEl.style.display = 'block';
            }
        } else {
            // Future date - all slots available
            availableSlots = timeSlots;
            hasAvailableSlots = true;
            messageEl.style.display = 'none';
        }
        
        // Populate select dropdown
        if (hasAvailableSlots) {
            timeSelect.innerHTML = '<option value="">Select time slot</option>' + 
                availableSlots.map(slot => 
                    `<option value="${slot.value}">${slot.label}</option>`
                ).join('');
        } else {
            timeSelect.innerHTML = '<option value="">No slots available for this date</option>';
        }
    }

    // Dine-in System Functions
    let selectedTable = null;

    async function selectOrderType(type) {
        document.getElementById('delivery-type').value = type;
        
        // Update UI
        document.getElementById('delivery-option').classList.toggle('active', type === 'delivery');
        document.getElementById('dinein-option').classList.toggle('active', type === 'dine-in');
        
        const addressSection = document.getElementById('delivery-address-section');
        const addressInputs = addressSection.querySelectorAll('input, select');
        
        if (type === 'dine-in') {
            document.getElementById('table-selection').style.display = 'block';
            addressSection.style.display = 'none';
            addressInputs.forEach(input => input.required = false);
            await loadAvailableTables();
        } else {
            document.getElementById('table-selection').style.display = 'none';
            addressSection.style.display = 'block';
            addressInputs.forEach(input => input.required = true);
            selectedTable = null;
            document.getElementById('table-number').value = '';
        }
        
        updatePaymentUI();
        calculateTotal();
    }

    async function loadAvailableTables() {
        try {
            const response = await fetch('/api/tables/available');
            const data = await response.json();
            
            const tableGrid = document.getElementById('table-grid');
            tableGrid.innerHTML = '';
            
            // Create table buttons 1-20
            for (let i = 1; i <= 20; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'table-btn';
                btn.textContent = `Table ${i}`;
                btn.dataset.tableNumber = i;
                
                // Check if table is available
                if (data.available_tables && data.available_tables.includes(i)) {
                    btn.onclick = () => selectTable(i);
                } else {
                    btn.disabled = true;
                    btn.title = 'Table occupied';
                }
                
                tableGrid.appendChild(btn);
            }
            
            document.getElementById('table-message').textContent = 
                `${data.available_tables ? data.available_tables.length : 0} tables available`;
                
        } catch (error) {
            console.error('Error loading tables:', error);
            document.getElementById('table-message').textContent = 'Unable to load tables';
        }
    }

    function selectTable(tableNumber) {
        selectedTable = tableNumber;
        document.getElementById('table-number').value = tableNumber;
        
        // Update UI
        document.querySelectorAll('.table-btn').forEach(btn => {
            btn.classList.remove('selected');
        });
        document.querySelector(`[data-table-number="${tableNumber}"]`).classList.add('selected');
        
        document.getElementById('table-message').textContent = `Table ${tableNumber} selected`;
        document.getElementById('table-message').style.color = '#28a745';
    }
</script>
@endsection
