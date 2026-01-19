@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <h1>Dashboard Overview</h1>
    <p class="text-muted">Live summary of your bakery operations</p>
</div>
<div class="stats-grid">
    <div class="stat-card" style="border-left: 5px solid #ff4757;">
        <h3>Reg Users</h3>
        <div class="stat-value">{{ $totalUsers }}</div>
    </div>
    <div class="stat-card" style="border-left: 5px solid #2ed573;">
        <h3>Listed Cakes</h3>
        <div class="stat-value">{{ $totalCakes }}</div>
    </div>
    <div class="stat-card" style="border-left: 5px solid #1e90ff;">
        <h3>Orders</h3>
        <div class="stat-value">{{ $totalOrders }}</div>
    </div>
    <div class="stat-card" style="border-left: 5px solid #a55eea;">
        <h3>Listed Brands</h3>
        <div class="stat-value">{{ $totalBrands }}</div>
    </div>
</div>

<div class="stats-grid" style="margin-top: 20px;">
    <div class="stat-card" style="border-left: 5px solid #ff9f43;">
        <h3>Subscribers</h3>
        <div class="stat-value">{{ $totalSubscribers }}</div>
    </div>
    <div class="stat-card" style="border-left: 5px solid #0abde3;">
        <h3>Queries</h3>
        <div class="stat-value">{{ $totalQueries }}</div>
    </div>
    <div class="stat-card" style="border-left: 5px solid #ee5253;">
        <h3>Testimonials</h3>
        <div class="stat-value">{{ $totalTestimonials }}</div>
    </div>
    <div class="stat-card" style="border-left: 5px solid #576574;">
        <h3>Employees</h3>
        <div class="stat-value">{{ $totalEmployees }}</div>
    </div>
</div>

<div class="card" style="margin-top: 30px;">
    <h3>Sales Overview (Monthly)</h3>
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<div class="top-products">
    <div class="card">
        <h3>Recent Orders <a href="{{ route('admin.orders.index') }}" style="font-size: 14px; color: var(--primary); text-decoration: none;">View All</a></h3>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>Rs {{ number_format($order->total_amount) }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
                @empty
                <tr><td colspan="4">No recent orders.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Top Selling Products</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>Rs {{ number_format($product->price) }}</td>
                    <td><strong>{{ $product->order_items_count }}</strong></td>
                </tr>
                @empty
                <tr><td colspan="3">No data available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Helper function to format numbers with commas
    function formatNumber(num) {
        return 'Rs ' + num.toLocaleString('en-IN');
    }

    // Helper function for Y-axis labels
    function formatYAxis(value) {
        return 'Rs ' + value.toLocaleString('en-IN');
    }

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($chartData);
    const maxValue = Math.max(...salesData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Monthly Sales',
                data: salesData,
                backgroundColor: 'rgba(212, 167, 106, 0.2)',
                borderColor: '#D4A76A',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#D4A76A',
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBorderWidth: 2
            }]
        },
        options: {
            scales: { 
                y: { 
                    beginAtZero: true,
                    min: 0,
                    max: 10000000, // 1 Crore
                    ticks: {
                        callback: function(value) {
                            return formatYAxis(value);
                        },
                        font: {
                            size: 12
                        },
                        // Custom step values: 0, 10K, 100K, 1M, 2M, 4M, 6M, 8M, 10M
                        stepSize: 1000000 // 1M intervals primarily
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 13,
                            weight: '500'
                        },
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return formatNumber(context.parsed.y);
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
    .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .stat-card h3 { font-size: 12px; text-transform: uppercase; color: #888; margin: 0 0 10px; }
    .stat-value { font-size: 24px; font-weight: 700; color: var(--secondary); }
    .top-products { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px; }
    .chart-container { height: 300px; margin-top: 20px; position: relative; }
</style>
@endpush
