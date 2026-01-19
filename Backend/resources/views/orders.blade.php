@extends('layouts.app')

@section('title', 'My Orders - Cinnamon Bakery')

@section('styles')
<style>
    .orders-container {
        padding: 50px 0;
        background: #fdf1e6;
        min-height: 80vh;
    }
    .order-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-5px);
    }
    .order-info h3 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 5px;
        color: var(--secondary);
    }
    .order-status {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-delivered { background: #cce5ff; color: #004085; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    
    .view-btn {
        background: var(--accent);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .view-btn:hover {
        background: #f7c873;
        box-shadow: 0 5px 15px rgba(247, 200, 115, 0.4);
    }
</style>
@endsection

@section('content')
<section class="orders-container">
    <div class="container" style="max-width: 900px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary);">My Orders</h1>
            <p style="color: #666;">Track your baked goodness from our oven to your door.</p>
        </div>

        @forelse($orders as $order)
        <div class="order-card">
            <div class="order-info">
                <h3>Order #{{ $order->order_number }}</h3>
                <p style="font-size: 14px; color: #888; margin-bottom: 10px;">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="order-status status-{{ $order->status }}">{{ str_replace('_', ' ', $order->status) }}</span>
                    <span style="font-weight: 700; color: var(--primary);">Rs. {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-end;">
                <a href="{{ route('order-tracking', ['order' => $order->order_number]) }}" class="view-btn">Track Order</a>
                <a href="{{ route('orders.invoice', $order->id) }}" class="view-btn" style="background: #5e4026; font-size: 13px; padding: 8px 15px;" target="_blank">
                    <i class="fas fa-file-invoice"></i> Download Slip
                </a>
                @if(in_array($order->status, ['pending', 'confirmed']))
                    <button onclick="cancelOrder({{ $order->id }})" class="view-btn" style="background: #dc3545; font-size: 12px; padding: 5px 10px;">Cancel Order</button>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 100px 0;">
            <i class="fas fa-box-open" style="font-size: 5rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3>No orders yet!</h3>
            <p>Your first delicious treats are just a few clicks away.</p>
            <a href="{{ route('browse-menu') }}" class="btn" style="display: inline-block; margin-top: 20px;">Browse Menu</a>
        </div>
        @endforelse

        <div style="margin-top: 30px;">
            {{ $orders->links() }}
        </div>
    </div>
</section>

<script>
    async function cancelOrder(orderId) {
        if (!confirm('Are you sure you want to cancel this order?')) return;
        
        try {
            const response = await fetch(`/orders/${orderId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await response.json();
            if (data.success) {
                showNotification(data.message);
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        } catch (e) {
            console.error(e);
            showNotification('An error occurred while cancelling the order.', 'error');
        }
    }
</script>
@endsection
