<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Cinnamon Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        :root {
            --primary: #D4A76A;
            --secondary: #7B3F00;
            --dark: #1E1E1E;
            --light: #f8f9fa;
            --sidebar-width: 250px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            color: #333;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h2 {
            font-size: 20px;
            color: var(--primary);
        }
        
        .sidebar-menu {
            padding: 20px 0;
            padding-bottom: 80px; /* Space for bottom scroll */
        }
        
        .menu-section-header {
            padding: 15px 25px 5px 25px;
            text-transform: uppercase;
            font-size: 11px;
            color: #6c757d;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .sidebar-menu a {
            display: block;
            padding: 10px 25px;
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: white;
            background: rgba(255,255,255,0.05);
            border-left-color: var(--primary);
        }
        
        .sidebar-menu i {
            width: 25px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 20px;
        }
        
        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-content {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            min-height: 80vh;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Common UI Elements */
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 14px;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table th {
            font-weight: 600;
            color: var(--secondary);
            background: #f8f9fa;
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        /* Additional UI Elements */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success { background: #28a745; color: white; }
        .badge-secondary { background: #6c757d; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        
        .btn-group {
            display: flex;
            gap: 5px;
        }
        
        .btn-info {
            background: #17a2b8;
            color: white;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .content-header h1 {
            font-size: 28px;
            color: var(--secondary);
        }
        
        .text-muted {
            color: #6c757d;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
        
        .mt-4 {
            margin-top: 1.5rem;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .col-md-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
            padding: 0 15px;
        }
        
        .col-md-8 {
            flex: 0 0 66.666%;
            max-width: 66.666%;
            padding: 0 15px;
        }
        
        .input-group {
            display: flex;
        }
        
        .input-group .form-control {
            flex: 1;
            border-radius: 5px 0 0 5px;
        }
        
        .input-group-append {
            display: flex;
        }
        
        .input-group-append .btn {
            border-radius: 0 5px 5px 0;
        }
        
        .custom-control-input {
            margin-right: 10px;
        }
        
        .custom-control-label {
            cursor: pointer;
        }
        
        .custom-control.custom-switch {
            display: flex;
            align-items: center;
        }
        
        .form-control-file {
            display: block;
            width: 100%;
        }
        
        .form-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .btn-outline { background: transparent; border: 1px solid var(--primary); color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: white; }
        
        /* Global Table Styles */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-weight: 600; font-size: 0.85rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
        td { font-size: 0.95rem; color: #333; vertical-align: middle; }
        tr:hover { background-color: #fcfcfc; }
        
        /* Badges & Status */
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }

        /* Media Queries */
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); width: 0; padding: 0; }
            .sidebar.active { transform: translateX(0); width: 260px; padding: 20px; }
            .main-content { margin-left: 0; }
            .main-content.active { margin-left: 260px; }
        }
        
        @media (max-width: 768px) {
            .col-md-4, .col-md-8 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h2>Cinnamon Bakery</h2>
            <p>Admin Panel</p>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <div class="menu-section-header">Catalog & Sales</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Orders
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-birthday-cake"></i> Products
            </a>
            <a href="{{ route('admin.brands.index') }}" class="{{ request()->is('admin/brands*') ? 'active' : '' }}">
                <i class="fas fa-copyright"></i> Brands
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="{{ route('admin.custom-cakes.index') }}" class="{{ request()->is('admin/custom-cakes*') ? 'active' : '' }}">
                <i class="fas fa-magic"></i> Custom Cakes
            </a>
            <a href="{{ route('admin.cake-options.index') }}" class="{{ request()->is('admin/cake-options*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Cake Options
            </a>
            <a href="{{ route('admin.dinein.index') }}" class="{{ request()->is('admin/dinein*') ? 'active' : '' }}">
                <i class="fas fa-chair"></i> Dine-In Tables
            </a>
            <a href="{{ route('admin.logistics.index') }}" class="{{ request()->is('admin/logistics*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i> Logistics
            </a>

            <div class="menu-section-header">Support & CRM</div>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Customers
            </a>
            <a href="{{ route('admin.queries.index') }}" class="{{ request()->is('admin/queries*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Inquiries
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                <i class="fas fa-comment-alt"></i> Testimonials
            </a>
            <a href="{{ route('admin.subscribers.index') }}" class="{{ request()->is('admin/subscribers*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i> Subscribers
            </a>

            <div class="menu-section-header">System</div>
            <a href="{{ route('admin.payments.index') }}" class="{{ request()->is('admin/payments') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Payments History
            </a>
            <a href="{{ route('admin.payment-methods.index') }}" class="{{ request()->is('admin/payment-methods*') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i> Payment Methods
            </a>
            
            <div class="menu-section-header">CMS Pages</div>
            <a href="{{ route('admin.features.index') }}" class="{{ request()->is('admin/features*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Features
            </a>
            <a href="{{ route('admin.help-contents.index') }}" class="{{ request()->is('admin/help-contents*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i> Help Center
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="{{ request()->is('admin/gallery*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Gallery
            </a>
            <a href="{{ route('admin.jobs.index') }}" class="{{ request()->is('admin/jobs*') && !request()->is('admin/job-applications*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i> Job Postings
            </a>
            <a href="{{ route('admin.jobs.applications') }}" class="{{ request()->is('admin/job-applications*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Job Applications
            </a>
            <a href="{{ route('admin.page-contents.index') }}" class="{{ request()->is('admin/page-contents*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Site Content
            </a>
            <a href="{{ route('admin.events.index') }}" class="{{ request()->is('admin/events*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Events
            </a>

            <div class="menu-section-header">Administration</div>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
            
            @if(auth()->check() && auth()->user()->role === 'superadmin')
            <a href="{{ route('admin.staff.index') }}" class="{{ request()->is('admin/staff*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Employees
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="{{ request()->is('admin/activity-logs*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Activity Logs
            </a>
            @endif

            <a href="{{ route('home') }}" target="_blank" style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
            <header>
                <div class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="header-right">
                    <a href="{{ route('home') }}" target="_blank" class="view-site-btn">View Website</a>
                    <div class="user-profile">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=D4A76A&color=fff" alt="Admin" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        <span>Hello, {{ auth()->check() ? auth()->user()->name : 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <div class="padding-container">
                 @hasSection('header')
                <div class="content-header">
                    <h1>@yield('header')</h1>
                    @hasSection('subheader')
                    <p class="text-muted">@yield('subheader')</p>
                    @endif
                </div>
                @endif

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Please fix the following errors:</strong>
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
</div>

<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('active');
        document.querySelector('.main-content').classList.toggle('active');
    }
</script>
@stack('scripts')
</body>
</html>
