<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cinnamon Bakery')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #D4A76A;
            --secondary: #7B3F00;
            --light: #FFF8F0;
            --dark: #1E1E1E;
            --accent: #FF9F1C;
            --accent2: #f7c873;
            --text: #333333;
            --card: #f9ede5;
            --gradient: linear-gradient(90deg, #fff8f0 0%, #ffe5d0 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(90deg, #fff8f0 60%, #ffe5d0 100%);
            box-shadow: 0 2px 10px rgba(231, 176, 122, 0.13);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--secondary);
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo i {
            color: var(--primary);
            margin-right: 10px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--secondary);
            font-weight: 600;
            font-size: 15px;
            position: relative;
            transition: all 0.3s ease;
            padding: 8px 18px;
            border-radius: 10px;
        }

        nav ul li a:hover,
        nav ul li a.active {
            background: #f7c873;
            color: var(--secondary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: var(--card);
            border-radius: 30px;
            padding: 8px 15px;
            box-shadow: 0 2px 8px rgba(231, 176, 122, 0.08);
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 180px;
            font-size: 14px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .profile-img, .initials-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(212, 165, 110, 0.3);
        }

        .cart-icon {
            position: relative;
            font-size: 20px;
            color: var(--dark);
            background: var(--card);
            border-radius: 50%;
            padding: 8px;
            transition: background 0.2s;
            text-decoration: none;
        }
        .cart-icon:hover {
            background: var(--accent2);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(231, 176, 122, 0.12);
        }

        .hamburger {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* Footer Styles */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 20px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h3 {
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 25px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-links i {
            margin-right: 10px;
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #888;
            font-size: 14px;
        }

        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            color: white;
            border-radius: 5px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        @media (max-width: 768px) {
            .hamburger { display: block; }
            nav { display: none; }
            nav.active { display: block; position: absolute; top: 100%; left: 0; width: 100%; background: var(--light); padding: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
            nav ul { flex-direction: column; gap: 15px; }
            .header-actions { gap: 10px; }
            .search-bar { display: none; }
        }
        /* IG Style Drawer */
        .ig-drawer {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: #121212;
            color: white;
            z-index: 1000;
            transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: -5px 0 25px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .ig-drawer.open { right: 0; }
        .ig-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.7);
            z-index: 999;
            display: none;
            backdrop-filter: blur(4px);
        }
        .ig-overlay.active { display: block; }
        .ig-header { padding: 20px; border-bottom: 1px solid #333; display: flex; align-items: center; gap: 15px; }
        .ig-header i { cursor: pointer; font-size: 20px; }
        .ig-header h2 { font-size: 18px; font-weight: 600; }
        
        .ig-section { border-bottom: 8px solid #000; padding: 15px 0; }
        .ig-section-title { padding: 5px 20px; font-size: 12px; font-weight: 700; color: #8e8e8e; text-transform: uppercase; margin-bottom: 10px; }
        
        .ig-item { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 12px 20px; 
            cursor: pointer; 
            transition: background 0.2s;
        }
        .ig-item:hover { background: #262626; }
        .ig-item-left { display: flex; align-items: center; gap: 15px; }
        .ig-item-left i { width: 24px; text-align: center; font-size: 18px; }
        .ig-item-right { color: #8e8e8e; font-size: 14px; }
        
        .ig-user-card { padding: 20px; display: flex; align-items: center; gap: 15px; background: #1a1a1a; }
        .ig-user-initial { width: 50px; height: 50px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; }
        .ig-user-info h3 { font-size: 16px; margin: 0; }
        .ig-user-info p { font-size: 13px; color: #8e8e8e; margin: 0; }

        .btn-logout-ig { color: #ed4956; font-weight: 600; cursor: pointer; padding: 15px 20px; border-top: 1px solid #333; margin-top: auto; display: flex; align-items: center; gap: 15px; }
        
        @media (max-width: 450px) {
            .ig-drawer { width: 100%; right: -100%; }
        }

        @yield('styles')
    </style>
</head>
<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- IG Settings Drawer -->
    <div class="ig-overlay" id="ig-overlay"></div>
    <div class="ig-drawer" id="ig-drawer">
        <div class="ig-header">
            <i class="fas fa-arrow-left" id="close-ig-settings"></i>
            <h2>Settings and activity</h2>
        </div>
        
        <div id="ig-content">
            <div class="ig-user-card">
                <div class="ig-user-initial" id="ig-user-initial">?</div>
                <div class="ig-user-info">
                    <h3 id="ig-user-name">Loading...</h3>
                    <p id="ig-user-email">...</p>
                </div>
            </div>

            <div class="ig-section">
                <div class="ig-section-title">How you use Cinnamon Bakery</div>
                <div class="ig-item" onclick="window.location='/cart'">
                    <div class="ig-item-left"><i class="fas fa-shopping-bag"></i> <span>My Cart</span></div>
                    <div class="ig-item-right"><span id="ig-cart-count">0</span> <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="ig-item" id="btn-show-wishlist" onclick="window.location='/wishlist'">
                    <div class="ig-item-left"><i class="fas fa-heart"></i> <span>Saved</span></div>
                    <div class="ig-item-right"><span id="ig-saved-count">0</span> <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="ig-item" onclick="window.location='/orders'">
                    <div class="ig-item-left"><i class="fas fa-receipt"></i> <span>Orders and payments</span></div>
                    <div class="ig-item-right"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>

            <div class="ig-section">
                <div class="ig-section-title">Account Settings</div>
                <div class="ig-item">
                    <div class="ig-item-left"><i class="fas fa-user-shield"></i> <span>Account privacy</span></div>
                    <div class="ig-item-right">Private <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="ig-item" onclick="window.location='/addresses'">
                    <div class="ig-item-left"><i class="fas fa-map-marker-alt"></i> <span>Stored Addresses</span></div>
                    <div class="ig-item-right"><span id="ig-addr-count">0</span> <i class="fas fa-chevron-right"></i></div>
                </div>
            </div>

            <div class="ig-section">
                <div class="ig-section-title">Support & Info</div>
                <div class="ig-item" onclick="window.location='/about'">
                    <div class="ig-item-left"><i class="fas fa-info-circle"></i> <span>About</span></div>
                    <div class="ig-item-right"><i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="ig-item" onclick="window.location='/help'">
                    <div class="ig-item-left"><i class="fas fa-question-circle"></i> <span>Help Center</span></div>
                    <div class="ig-item-right"><i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="ig-item" onclick="window.location='/careers'">
                    <div class="ig-item-left"><i class="fas fa-briefcase"></i> <span>Careers</span></div>
                    <div class="ig-item-right"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>

            <div class="btn-logout-ig" onclick="document.getElementById('logout-form').submit()">
                <i class="fas fa-sign-out-alt"></i> <span>Log out</span>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </div>

    <script>
        const BASE_URL = '{{ url('/') }}';
        const API_BASE = BASE_URL + '/api';
        const CHATBOT_API = API_BASE + '/chatbot';
        const CART_API = BASE_URL + '/cart';
        const AUTH_API = BASE_URL; 
        const PROFILE_API = BASE_URL + '/profile';
        let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            checkAuthStatus();
            
            // Mobile Menu
            const hamburger = document.getElementById('hamburger');
            if (hamburger) {
                hamburger.addEventListener('click', () => {
                    const nav = document.getElementById('main-nav');
                    if (nav) nav.classList.toggle('active');
                });
            }

            // IG Drawer Controls
            document.getElementById('close-ig-settings')?.addEventListener('click', closeIgSettings);
            document.getElementById('ig-overlay')?.addEventListener('click', closeIgSettings);
            document.getElementById('btn-show-wishlist')?.addEventListener('click', () => {
                window.location.href = '/wishlist';
            });
        });

        async function checkAuthStatus() {
            try {
                const response = await fetch(`${AUTH_API}/user-info`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    credentials: 'include'
                });
                if (response.ok) {
                    const data = await response.json();
                    updateUIForLoggedInUser(data.user);
                }
            } catch (error) {}
        }

        async function updateCartCount() {
            try {
                const response = await fetch(`${CART_API}/count`);
                const data = await response.json();
                const cartCountEls = document.querySelectorAll('.cart-count');
                cartCountEls.forEach(el => {
                    el.textContent = data.item_count || 0;
                });
                const igCartCount = document.getElementById('ig-cart-count');
                if(igCartCount) igCartCount.textContent = data.item_count || 0;
            } catch (error) {
                console.error('Error fetching cart:', error);
            }
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.backgroundColor = type === 'success' ? '#4CAF50' : '#f44336';
            
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        async function addToCart(productId, productName, price, quantity = 1) {
            try {
                const response = await fetch(`${CART_API}/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        item_name: productName,
                        quantity: quantity,
                        unit_price: price
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    updateCartCount();
                    showNotification('Item added to cart!');
                    return data;
                } else if (response.status === 401) {
                    showNotification('Please login before adding items to cart.', 'error');
                    setTimeout(() => {
                        window.location.href = '{{ route("login") }}';
                    }, 1500);
                    return;
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                showNotification(error.message, 'error');
                // Don't rethrow if we handled it
                if (!error.message.includes('Please login')) {
                    throw error;
                }
            }
        }

        function updateUIForLoggedInUser(user) {
            if (!user) return;
            
            const profileLinks = document.querySelectorAll('.profile');
            const initial = user.name.charAt(0).toUpperCase();

            profileLinks.forEach(link => {
                link.innerHTML = `
                    <div class="initials-circle profile-click-target">${initial}</div>
                `;
                link.href = '#';
                
                // Single click to open drawer
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    openIgSettings();
                });
            });

            // Pre-fill drawer info so it's ready even before fetching stats
            const nameEl = document.getElementById('ig-user-name');
            const emailEl = document.getElementById('ig-user-email');
            const initialEl = document.getElementById('ig-user-initial');
            if (nameEl) nameEl.textContent = user.name;
            if (emailEl) emailEl.textContent = user.email;
            if (initialEl) initialEl.textContent = initial;
        }

        async function openIgSettings() {
            const drawer = document.getElementById('ig-drawer');
            const overlay = document.getElementById('ig-overlay');
            
            drawer.classList.add('open');
            overlay.classList.add('active');

            // Fetch Latest Info
            try {
                const response = await fetch(`${PROFILE_API}/settings`);
                if(response.ok) {
                    const data = await response.json();
                    document.getElementById('ig-user-name').textContent = data.user.name;
                    document.getElementById('ig-user-email').textContent = data.user.email;
                    document.getElementById('ig-user-initial').textContent = data.user.initial;
                    document.getElementById('ig-saved-count').textContent = data.stats.saved_count;
                    document.getElementById('ig-addr-count').textContent = data.addresses.length;
                    
                    updateCartCount(); // Refresh cart count in drawer too
                }
            } catch (e) { console.error("Error fetching settings", e); }
        }

        function closeIgSettings() {
            document.getElementById('ig-drawer').classList.remove('open');
            document.getElementById('ig-overlay').classList.remove('active');
        }
    </script>
    @yield('scripts')
    @include('partials.chatbot')
</body>
</html>
