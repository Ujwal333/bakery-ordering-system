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
            font-size: 16px;
            position: relative;
            transition: all 0.3s ease;
            padding: 4px 10px;
            border-radius: 6px;
        }

        nav ul li a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent);
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }

        nav ul li a:hover,
        nav ul li a.active {
            background: var(--accent2);
            color: var(--dark);
        }
        nav ul li a:hover:after,
        nav ul li a.active:after {
            width: 100%;
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

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
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
        @yield('styles')
    </style>
</head>
<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <script>
        const API_BASE = '';
        const CART_API = '/cart';
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
        });

        async function checkAuthStatus() {
            try {
                const response = await fetch(`${API_BASE}/user`, {
                    headers: { 'Accept': 'application/json' },
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
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                showNotification(error.message, 'error');
                throw error;
            }
        }

        function updateUIForLoggedInUser(user) {
            const profileLinks = document.querySelectorAll('.profile');
            profileLinks.forEach(link => {
                if (user) {
                    link.innerHTML = `
                        <img src="${user.profile_image}" alt="Profile" class="profile-img">
                        <span>${user.name}</span>
                    `;
                    link.href = '#'; // Could link to profile page
                }
            });
        }
    </script>
    @yield('scripts')
</body>
</html>
