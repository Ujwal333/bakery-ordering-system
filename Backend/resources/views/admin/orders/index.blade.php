@extends('admin.layout')

@section('content')
<div class="header-flex">
    <h2>Order Management</h2>
</div>

<div class="card" style="margin-bottom: 20px;">
    <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 15px; padding: 15px;">
        <input type="text" name="search" class="form-control" placeholder="Search Order ID, Name, Email" value="{{ request('search') }}" style="flex: 2;">
        
        <select name="status" class="form-control" style="flex: 1;">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
            <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary" style="text-decoration:none; display:flex; align-items:center;">Reset</a>
    </form>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>
                    {{ $order->customer_name }}<br>
                    <small style="color: #666;">{{ $order->customer_phone }}</small>
                </td>
                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                <td>Rs {{ number_format($order->total_amount, 2) }}</td>
                <td>
                    <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                    <br><small>{{ strtoupper($order->payment_method) }}</small>
                </td>
                <td>
                    @php
                        $statusColors = [
                            'pending' => '#ff9800',
                            'confirmed' => '#2196F3',
                            'preparing' => '#9C27B0',
                            'out_for_delivery' => '#00BCD4',
                            'delivered' => '#4CAF50',
                            'cancelled' => '#F44336',
                        ];
                        $color = $statusColors[$order->status] ?? '#999';
                    @endphp
                    <span class="badge" style="background-color: {{ $color }}; color: white;">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px;">
                    No orders found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="padding: 20px;">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-success { background-color: #4CAF50; color: white; }
    .badge-warning { background-color: #FB8C00; color: white; }
</style>
@endsection
