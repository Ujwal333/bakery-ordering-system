@extends('admin.layout')

@section('title', 'Order #' . $order->order_number)
@section('header', 'Order Details')
@section('subheader', 'Order ID: #' . $order->order_number)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <div>
        <div class="card">
            <h3>Ordered Items</h3>
            <table style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <img src="{{ asset('storage/' . ($item->product->image_url ?? '')) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                <div>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    @if($item->custom_message)
                                        <small style="color:var(--primary);">Message: "{{ $item->custom_message }}"</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>Rs {{ number_format($item->unit_price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td><strong>Rs {{ number_format($item->unit_price * $item->quantity) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; padding-top: 30px;">Subtotal:</td>
                        <td style="padding-top: 30px;">Rs {{ number_format($order->subtotal) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right; border:none;">Delivery Charge:</td>
                        <td style="border:none;">Rs {{ number_format($order->delivery_charge) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right; border:none; font-size: 18px;"><strong>Total:</strong></td>
                        <td style="border:none; font-size: 18px; color: var(--primary);"><strong>Rs {{ number_format($order->total_amount) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card">
            <h3>{{ $order->delivery_type === 'dine-in' ? 'Dining Information' : 'Delivery Information' }}</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Customer Name</label>
                    <p><strong>{{ $order->customer_name }}</strong></p>
                    <small style="color:#888;">{{ $order->customer_email }}</small>
                </div>
                <div>
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Phone Number</label>
                    <p><strong>{{ $order->customer_phone }}</strong></p>
                </div>
                
                @if($order->delivery_type === 'dine-in')
                <div style="grid-column: span 2; background: #fffaf5; padding: 15px; border-radius: 10px; border: 1px dashed var(--primary);">
                    <label style="color:var(--primary); font-size:12px; text-transform:uppercase; font-weight: bold;">Dining Table</label>
                    <p style="font-size: 24px; margin: 0;"><strong>🪑 Table {{ $order->table_number }}</strong></p>
                    <small style="color:#888;">Customer is currently seated at table {{ $order->table_number }}.</small>
                </div>
                @else
                <div style="grid-column: span 2;">
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Delivery Address</label>
                    <p><strong>{{ $order->delivery_address }}</strong></p>
                    <p style="color:#666; font-size:13px;">{{ $order->delivery_area }}, {{ $order->delivery_city }}</p>
                </div>
                @endif
                @if($order->special_instructions)
                        <div style="margin-top:10px; padding:10px; background:#f9f9f9; border-left:3px solid var(--primary);">
                            <label style="font-size:10px; text-transform:uppercase; color:#888;">Instructions</label>
                            <p style="font-size:13px;">{{ $order->special_instructions }}</p>
                        </div>
                    @endif
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <h3>Order Status</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="margin-top: 20px;">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <select name="status" class="form-control" style="background: var(--light);">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing / Baking</option>
                        <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready for Handover</option>
                        <option value="with_logistic" {{ $order->status == 'with_logistic' ? 'selected' : '' }}>With Logistic / Ready to deliver</option>
                        <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Status</button>
            </form>
            
            @if(in_array($order->status, ['preparing', 'ready']))
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee;">
                @php $activeLogistics = \App\Models\LogisticPartner::where('is_active', true)->get(); @endphp
                
                @if($activeLogistics->count() > 0)
                <form action="{{ route('admin.orders.handover', $order) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label style="font-size: 11px; text-transform: uppercase; color: #888;">Select Partner</label>
                        <select name="logistic_partner_id" class="form-control" required style="font-size: 13px;">
                            <option value="">-- Choose Partner --</option>
                            @foreach($activeLogistics as $lp)
                                <option value="{{ $lp->id }}">{{ $lp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #2ed573;">
                        <i class="fas fa-shipping-fast"></i> Assign & Handover
                    </button>
                </form>
                @else
                <div style="text-align: center;">
                    <p style="font-size: 12px; color: #dc3545;">No active logistic partners found.</p>
                    <a href="{{ route('admin.logistics.index') }}" class="btn btn-sm btn-outline" style="font-size: 11px; margin-top: 5px;">Manage Logistics</a>
                </div>
                @endif
            </div>
            @elseif($order->status === 'with_logistic' && $order->logisticPartner)
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee;">
                <label style="font-size: 11px; text-transform: uppercase; color: #888;">Assigned To</label>
                <p><strong><i class="fas fa-truck"></i> {{ $order->logisticPartner->name }}</strong></p>
                <small style="color: #666;">Handed over: {{ $order->handed_over_at ? $order->handed_over_at->diffForHumans() : 'N/A' }}</small>
            </div>
            @endif
        </div>

        <div class="card">
            <h3>Payment Status</h3>
            <div style="margin-top: 20px;">
                @php $payment = $order->payments->first(); @endphp
                @if($payment)
                    <p>Method: <strong>{{ strtoupper($payment->provider) }}</strong></p>
                    <p>Amount: <strong>Rs {{ number_format($payment->amount) }}</strong></p>
                    <p>Transaction ID: <span style="font-family: monospace; color:#666;">{{ $payment->transaction_id }}</span></p>
                    <p>Status: <span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></p>
                @else
                    <p style="color:var(--text-muted);">No payment record found.</p>
                @endif

                @if($order->payment_status !== 'paid')
                    @if($payment)
                        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST" style="margin-top: 15px;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-outline" style="width: 100%; color: #60bb46; border-color: #60bb46;">
                                <i class="fas fa-check-circle"></i> Mark as Paid Manually
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="margin-top: 15px;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <input type="hidden" name="mark_as_paid" value="1">
                            <button type="submit" class="btn btn-outline" style="width: 100%; color: #60bb46; border-color: #60bb46;">
                                <i class="fas fa-check-circle"></i> Mark as Paid Manually
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center;">
            <i class="fas fa-file-invoice"></i> Print Invoice
        </a>
    </div>
</div>
@endsection
