@extends('layouts.app')

@section('title', 'Shopping Cart - Cinnamon Bakery')

@section('styles')
    <style>
        .cart-section { padding: 80px 0; min-height: 70vh; }
        .cart-title { text-align: center; margin-bottom: 50px; }
        .cart-title h1 { font-family: 'Playfair Display', serif; font-size: 42px; color: var(--secondary); margin-bottom: 15px; }
        .cart-container { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        @media (max-width: 992px) { .cart-container { grid-template-columns: 1fr; } }
        .cart-items { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); }
        .cart-empty { text-align: center; padding: 60px 20px; display: none; }
        .cart-item { display: flex; align-items: center; padding: 20px; border-bottom: 1px solid #eee; gap: 20px; }
        .item-image { width: 100px; height: 100px; border-radius: 10px; overflow: hidden; flex-shrink: 0; background: #f0f0f0; }
        .item-image img { width: 100%; height: 100%; object-fit: cover; }
        .item-details { flex-grow: 1; }
        .item-name { font-size: 18px; font-weight: 600; color: var(--secondary); margin-bottom: 5px; }
        .item-price { font-weight: 600; color: var(--accent); font-size: 18px; }
        .item-quantity { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
        .quantity-btn { width: 30px; height: 30px; border-radius: 50%; background: var(--primary); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
        .quantity-btn:hover { background: var(--secondary); }
        .quantity-display { min-width: 40px; text-align: center; font-weight: 600; }
        .item-remove { color: #ff4757; background: none; border: none; cursor: pointer; padding: 5px 10px; border-radius: 5px; font-size: 18px; }
        .order-summary { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); height: fit-content; }
        .summary-title { font-size: 24px; color: var(--secondary); margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary); }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .summary-total { font-size: 20px; font-weight: 700; color: var(--secondary); margin-top: 20px; padding-top: 20px; border-top: 2px solid #eee; display: flex; justify-content: space-between; }
        .btn-checkout { display: block; width: 100%; padding: 15px; background: linear-gradient(to right, var(--secondary), var(--primary)); color: white; text-align: center; text-decoration: none; border-radius: 30px; font-weight: 600; margin-top: 30px; border: none; cursor: pointer; font-size: 16px; }
    </style>
@endsection

@section('content')
    <section class="cart-section">
        <div class="container">
            <div class="cart-title">
                <h1>Your Shopping Cart</h1>
                <p>Review your delicious selection before checking out</p>
            </div>

            <div class="cart-container">
                <div class="cart-items" id="cart-items-container">
                    <div style="text-align:center; padding: 40px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 40px; color: var(--primary);"></i>
                        <p style="margin-top: 10px;">Loading cart...</p>
                    </div>
                </div>

                <div class="cart-empty" id="cart-empty-message">
                    <i class="fas fa-basket-shopping" style="font-size: 3rem; color: var(--primary); margin-bottom: 20px; display: block;"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any treats yet.</p>
                    <a href="{{ route('browse-menu') }}" class="btn-checkout" style="max-width: 200px; margin: 20px auto;">Browse Menu</a>
                </div>

                <div class="order-summary" id="order-summary-box">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-item"><span>Subtotal</span><span id="summary-subtotal">Rs 0</span></div>
                    <div class="summary-item"><span>Delivery Fee</span><span>Rs 50</span></div>
                    <div class="summary-total"><span>Total</span><span id="summary-total">Rs 50</span></div>
                    <a href="{{ route('checkout') }}" class="btn-checkout">Proceed to Checkout</a>
                    <button onclick="clearCart()" style="background:none; border:none; text-decoration:underline; color:#666; width:100%; margin-top:15px; cursor:pointer;">Clear Cart</button>
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
                renderCart(data);
            } catch (error) {
                console.error('Error fetching cart:', error);
            }
        }

        function renderCart(data) {
            const container = document.getElementById('cart-items-container');
            const summaryBox = document.getElementById('order-summary-box');
            const emptyMsg = document.getElementById('cart-empty-message');

            if (data.cart.items.length === 0) {
                container.style.display = 'none';
                summaryBox.style.display = 'none';
                emptyMsg.style.display = 'block';
                return;
            }

            container.style.display = 'block';
            summaryBox.style.display = 'block';
            emptyMsg.style.display = 'none';

            let html = '';
            data.cart.items.forEach(item => {
                let imgUrl = item.product && item.product.image_url ? 
                    (item.product.image_url.startsWith('http') ? item.product.image_url : `/storage/${item.product.image_url}`) : 
                    'https://via.placeholder.com/100';

                html += `
                    <div class="cart-item">
                        <div class="item-image"><img src="${imgUrl}" alt="${item.item_name}"></div>
                        <div class="item-details">
                            <h3 class="item-name">${item.item_name}</h3>
                            <div class="item-price">Rs ${parseFloat(item.unit_price).toFixed(0)}</div>
                            <div class="item-quantity">
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.quantity - 1})"><i class="fas fa-minus"></i></button>
                                <span class="quantity-display">${item.quantity}</span>
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.quantity + 1})"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <button class="item-remove" onclick="removeItem(${item.id})"><i class="fas fa-trash"></i></button>
                    </div>
                `;
            });

            container.innerHTML = html;
            document.getElementById('summary-subtotal').textContent = `Rs ${data.subtotal}`;
            document.getElementById('summary-total').textContent = `Rs ${parseFloat(data.subtotal) + 50}`;
            updateCartCount(); // Shared function from layout
        }

        async function updateQuantity(itemId, newQty) {
            if (newQty < 1) return;
            await fetch(`/cart/item/${itemId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ quantity: newQty })
            });
            fetchCart();
        }

        async function removeItem(itemId) {
            if (!confirm('Remove item?')) return;
            await fetch(`/cart/item/${itemId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            fetchCart();
        }

        async function clearCart() {
            if (!confirm('Clear cart?')) return;
            await fetch('/cart/clear', {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            fetchCart();
        }
    </script>
@endsection
