<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Cinnamon Bakery Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #D4A76A;
            --secondary: #2C1810;
            --accent: #FF9F1C;
            --light: #F9F5F0;
            --sidebar: #1a0f0a;
            --white: #ffffff;
            --danger: #ff4757;
            --success: #2ecc71;
            --text-muted: #888;
        }

        body { font-family: 'Poppins', sans-serif; margin: 0; display: flex; background: var(--light); color: #333; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar); height: 100vh; color: white; padding: 30px 0; position: fixed; z-index: 100; overflow-y: auto; }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: var(--sidebar); }
        .sidebar::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar-logo { padding: 0 30px 40px; font-family: 'Playfair Display', serif; font-size: 22px; display: flex; align-items: center; gap: 10px; }
        .sidebar-logo i { color: var(--primary); }
        .nav-links { list-style: none; padding: 0; }
        .nav-links li { padding: 5px 20px; }
        .nav-links a { display: flex; align-items: center; gap: 15px; padding: 12px 15px; color: #ccc; text-decoration: none; border-radius: 10px; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { background: var(--primary); color: white; }
        
        /* Main Content */
        .main-content { margin-left: 260px; flex-grow: 1; min-height: 100vh; padding: 40px; box-sizing: border-box; }
        header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        h1 { margin: 0; font-size: 28px; color: var(--secondary); }
        
        /* Components */
        .card { background: var(--white); border-radius: 20px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .btn { padding: 10px 20px; border-radius: 10px; cursor: pointer; border: none; font-family: inherit; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: #c39659; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-outline { border: 1px solid #ddd; background: transparent; color: #666; }
        
        .alert { padding: 15px 20px; border-radius: 12px; margin-bottom: 30px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; border-bottom: 1px solid #eee; color: var(--text-muted); font-weight: 500; font-size: 14px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f9f9f9; font-size: 15px; }
        
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .badge-active { background: #e8f5e9; color: #2e7d32; }
        .badge-inactive { background: #ffebee; color: #c62828; }

        .btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 8px; }
        .btn-danger-outline { color: var(--danger); border: 1px solid var(--danger); background: transparent; }
        .btn-danger-outline:hover { background: var(--danger); color: white; }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; font-family: inherit; font-size: 14px; box-sizing: border-box; }
        .form-control:focus { outline: none; border-color: var(--primary); }
        
        @stack('styles')
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-bread-slice"></i>
            <span>Cinnamon Admin</span>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            
            <li style="color: #555; font-size: 11px; text-transform: uppercase; margin-top: 20px; padding-left: 20px;">Catalog & Sales</li>
            <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}"><i class="fas fa-shopping-basket"></i> Orders</a></li>
            <li><a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}"><i class="fas fa-cookie"></i> Products</a></li>
            <li><a href="{{ route('admin.brands.index') }}" class="{{ request()->is('admin/brands*') ? 'active' : '' }}"><i class="fas fa-tags"></i> Brands</a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}"><i class="fas fa-list"></i> Categories</a></li>
            <li><a href="{{ route('admin.custom-cakes.index') }}" class="{{ request()->is('admin/custom-cakes*') ? 'active' : '' }}"><i class="fas fa-birthday-cake"></i> Custom Cakes</a></li>
            <li><a href="{{ route('admin.cake-options.index') }}" class="{{ request()->is('admin/cake-options*') ? 'active' : '' }}"><i class="fas fa-sliders-h"></i> Cake Options</a></li>
            
            <li style="color: #555; font-size: 11px; text-transform: uppercase; margin-top: 20px; padding-left: 20px;">Support & CRM</li>
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="{{ route('admin.queries.index') }}" class="{{ request()->is('admin/queries*') ? 'active' : '' }}"><i class="fas fa-question-circle"></i> Inquiries</a></li>
            <li><a href="{{ route('admin.testimonials.index') }}" class="{{ request()->is('admin/testimonials*') ? 'active' : '' }}"><i class="fas fa-star"></i> Testimonials</a></li>
            <li><a href="{{ route('admin.subscribers.index') }}" class="{{ request()->is('admin/subscribers*') ? 'active' : '' }}"><i class="fas fa-envelope"></i> Subscribers</a></li>
            
            <li style="color: #555; font-size: 11px; text-transform: uppercase; margin-top: 20px; padding-left: 20px;">System</li>
            <li><a href="{{ route('admin.payments.index') }}" class="{{ request()->is('admin/payments*') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Payments</a></li>
            <li><a href="{{ route('admin.pages.index') }}" class="{{ request()->is('admin/pages*') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> CMS Pages</a></li>
            <li><a href="{{ route('admin.events.index') }}" class="{{ request()->is('admin/events*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Events</a></li>
            @if(Auth::guard('admin')->user()->role == 'superadmin')
                <li><a href="{{ route('admin.staff.index') }}" class="{{ request()->is('admin/staff*') ? 'active' : '' }}"><i class="fas fa-user-shield"></i> Employees</a></li>
                <li><a href="{{ route('admin.activity-logs.index') }}" class="{{ request()->is('admin/activity-logs*') ? 'active' : '' }}"><i class="fas fa-history"></i> Activity Logs</a></li>
                <li><a href="{{ route('admin.settings.index') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}"><i class="fas fa-cog"></i> Settings</a></li>
            @endif
        </ul>
    </div>

    <div class="main-content">
        <header>
            <div>
                <h1>@yield('header')</h1>
                <p class="text-muted">@yield('subheader')</p>
            </div>
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="position: relative; margin-right: 15px;">
                    <i class="fas fa-bell" style="color: #888; font-size: 20px; cursor: pointer;"></i>
                    @php $unreadCount = Auth::guard('admin')->user()->unreadNotifications->count(); @endphp
                    @if($unreadCount > 0)
                        <span style="position: absolute; top: -8px; right: -8px; background: var(--danger); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center;">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </div>
                <span class="text-muted">Hello, <strong>{{ Auth::guard('admin')->user()->name }}</strong></span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 6px 15px; font-size: 13px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
