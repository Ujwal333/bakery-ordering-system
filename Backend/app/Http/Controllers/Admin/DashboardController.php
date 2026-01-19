<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with real database statistics
     */
    public function index()
    {
        // Total Users
        $totalUsers = User::count();

        // Total Orders
        $totalOrders = Order::count();

        // Today's Orders
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Pending Orders
        $pendingOrders = Order::whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->count();

        // Total Revenue (sum of paid orders only)
        $totalRevenue = Payment::where('status', 'completed')
            ->sum('amount');

        // Today's Revenue
        $todayRevenue = Payment::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        // Recent Orders (last 10)
        $recentOrders = Order::with('user', 'payments')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top Products (by order count)
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        // Order Status Distribution
        $ordersByStatus = Order::select('status')
            ->groupBy('status')
            ->selectRaw('count(*) as total')
            ->get()
            ->pluck('total', 'status');

        // Payment Method Distribution
        $paymentMethods = Payment::where('status', 'completed')
            ->select('provider')
            ->groupBy('provider')
            ->selectRaw('count(*) as total, sum(amount) as revenue')
            ->get();

        // Monthly Sales Graph (Last 12 Months) - Based on Delivered Orders
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            // Calculate revenue from delivered/completed orders only
            $monthlySales = Order::whereIn('status', ['delivered'])
                ->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('total_amount');
                
            $chartLabels[] = $monthName;
            $chartData[] = (float) $monthlySales; // Ensure it's a number
        }

        // Additional Stats for complete system
        $totalCakes = Product::count();
        $totalBrands = \App\Models\Brand::count();
        $totalSubscribers = \App\Models\Subscriber::count();
        $totalQueries = \App\Models\ContactQuery::count();
        $totalTestimonials = \App\Models\Testimonial::count();
        $totalEmployees = \App\Models\Admin::count();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'todayOrders' => $todayOrders,
            'pendingOrders' => $pendingOrders,
            'totalRevenue' => $totalRevenue,
            'todayRevenue' => $todayRevenue,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'ordersByStatus' => $ordersByStatus,
            'paymentMethods' => $paymentMethods,
            'totalCakes' => $totalCakes,
            'totalBrands' => $totalBrands,
            'totalSubscribers' => $totalSubscribers,
            'totalQueries' => $totalQueries,
            'totalTestimonials' => $totalTestimonials,
            'totalEmployees' => $totalEmployees,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}

