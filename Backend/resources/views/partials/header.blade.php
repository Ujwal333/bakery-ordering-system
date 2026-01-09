<header>
    <div class="container header-container">
        <a href="{{ route('home') }}" class="logo">
            <i class="fas fa-bread-slice"></i>
            <span>Cinnamon Bakery</span>
        </a>
        <div class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
        <nav id="main-nav">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('browse-menu') }}" class="{{ request()->routeIs('browse-menu') ? 'active' : '' }}">Browse Menu</a></li>
                <li><a href="{{ route('custom-cake') }}" class="{{ request()->routeIs('custom-cake') ? 'active' : '' }}">Custom Cakes</a></li>
                <li><a href="{{ route('order-tracking') }}" class="{{ request()->routeIs('order-tracking') ? 'active' : '' }}">Order Tracking</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('features') }}" class="{{ request()->routeIs('features') ? 'active' : '' }}">Features</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <!-- Dynamic profile based on auth -->
            <a href="{{ route('login') }}" class="profile" id="profile-login-link">
                @auth
                    <img src="{{ Auth::user()->profile_image }}" alt="Profile" class="profile-img">
                    <span>{{ Auth::user()->name }}</span>
                @else
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="profile-img">
                @endauth
            </a>
            <!-- Dynamic cart count -->
            <a href="{{ route('cart') }}" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count">0</span>
            </a>
        </div>
    </div>
</header>
