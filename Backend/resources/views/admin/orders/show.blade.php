@extends('admin.layout')

@section('content')
<div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Order #{{ $order->order_number }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- Main Order Details -->
    <div>
        <!-- Items Card -->
        <div class="card" style="margin-bottom: 20px; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white;">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Order Items</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->item_name }}</strong>
                            @if($item->customizations)
                                <div style="font-size: 12px; color: #666;">
                                    @php $customs = json_decode($item->customizations, true); @endphp
                                    @foreach($customs as $key => $value)
                                        {{ ucfirst($key) }}: {{ $value }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rs {{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Subtotal:</strong></td>
                        <td>Rs {{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Delivery Charge:</strong></td>
                        <td>Rs {{ number_format($order->delivery_charge, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Tax:</strong></td>
                        <td>Rs {{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right; font-size: 1.2em;"><strong>Total Amount:</strong></td>
                        <td style="font-size: 1.2em; color: var(--primary); font-weight: 700;">Rs {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- History Card -->
        <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white;">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Tracking History</h3>
            <div class="timeline" style="position: relative; padding-left: 30px;">
                @foreach($order->tracking->sortByDesc('created_at') as $tracking)
                <div class="timeline-item" style="position: relative; margin-bottom: 20px;">
                    <div style="position: absolute; left: -30px; width: 12px; height: 12px; border-radius: 50%; background: var(--primary); top: 5px; border: 2px solid white; box-shadow: 0 0 0 2px var(--primary);"></div>
                    <strong>{{ ucfirst(str_replace('_', ' ', $tracking->status)) }}</strong>
                    <div style="font-size: 12px; color: #666;">{{ $tracking->created_at->format('d M Y, h:i A') }}</div>
                    <p style="margin-top: 5px; font-size: 14px;">{{ $tracking->message }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div>
        <!-- Customer Info -->
        <div class="card" style="margin-bottom: 20px; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white;">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Customer Info</h3>
            <div style="margin-bottom: 10px;">
                <label style="color: #666; font-size: 12px;">Name</label>
                <div>{{ $order->customer_name }}</div>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: #666; font-size: 12px;">Email</label>
                <div>{{ $order->customer_email }}</div>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: #666; font-size: 12px;">Phone</label>
                <div>{{ $order->customer_phone }}</div>
            </div>
        </div>

        <!-- Delivery Info -->
        <div class="card" style="margin-bottom: 20px; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white;">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Delivery Details</h3>
            <div style="margin-bottom: 10px;">
                <label style="color: #666; font-size: 12px;">Address</label>
                <div>{{ $order->delivery_address }}, {{ $order->delivery_city }}, {{ $order->delivery_state }} {{ $order->delivery_zip }}</div>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: #666; font-size: 12px;">Type</label>
                <div>{{ ucfirst($order->delivery_type) }}</div>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: #666; font-size: 12px;">Scheduled</label>
                <div>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }} at {{ $order->delivery_time }}</div>
            </div>
        </div>

        <!-- Order Status Update -->
        <div class="card" style="margin-bottom: 20px; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white; border-top: 4px solid var(--primary);">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Manage Status</h3>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Order Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div id="cancellation_reason_div" style="display: {{ $order->status == 'cancelled' ? 'block' : 'none' }}; margin-bottom: 15px;">
                    <label>Cancellation Reason</label>
                    <textarea name="cancellation_reason" class="form-control">{{ $order->cancellation_reason }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Status</button>
            </form>

            <hr style="margin: 20px 0;">

            <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Payment Status ({{ strtoupper($order->payment_method) }})</label>
                    <select name="payment_status" class="form-control">
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary" style="width: 100%; justify-content: center;">Update Payment</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('select[name="status"]').addEventListener('change', function() {
        if (this.value === 'cancelled') {
            document.getElementById('cancellation_reason_div').style.display = 'block';
        } else {
            document.getElementById('cancellation_reason_div').style.display = 'none';
        }
    });
</script>

<style>
    .timeline::before {
        content: '';
        position: absolute;
        left: 5px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #eee;
    }
</style>
@endsection
