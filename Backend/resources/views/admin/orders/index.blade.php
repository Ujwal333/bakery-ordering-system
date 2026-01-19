@extends('admin.layout')

@section('title', 'Orders')
@section('header', 'Order Management')
@section('subheader', 'Track and manage customer orders')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">All Orders</h3>
        <div style="display: flex; gap: 10px;">
            <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 10px;">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="with_logistic" {{ request('status') == 'with_logistic' ? 'selected' : '' }}>With Logistic</option>
                    <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Type</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td><strong>#{{ $order->id }}</strong></td>
                <td>
                    {{ $order->user->name ?? 'Guest' }}<br>
                    <small style="color:#888;">{{ $order->user->phone ?? $order->phone }}</small>
                </td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                    @if($order->delivery_type === 'dine-in')
                        <span style="color: var(--primary);">🪑 Table {{ $order->table_number }}</span>
                    @elseif($order->delivery_type === 'pickup')
                        <span style="color: #666;">🛍️ Pickup</span>
                    @else
                        <span style="color: #666;">🚚 Delivery</span>
                    @endif
                </td>
                <td><strong>Rs {{ number_format($order->total_amount) }}</strong></td>
                <td>
                    <span class="badge badge-{{ $order->status }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline" style="padding: 5px 12px; font-size: 13px;">
                        <i class="fas fa-eye"></i> Details
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
