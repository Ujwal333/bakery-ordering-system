@extends('admin.layout')

@section('title', 'Payments')
@section('header', 'Payment Transactions')
@section('subheader', 'Monitor and verify digital payments')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">Transaction History</h3>
        <div style="display: flex; gap: 10px;">
            <form action="{{ route('admin.payments.index') }}" method="GET" style="display: flex; gap: 10px;">
                <select name="provider" class="form-control" onchange="this.form.submit()">
                    <option value="all" {{ request('provider') == 'all' ? 'selected' : '' }}>All Providers</option>
                    <option value="esewa" {{ request('provider') == 'esewa' ? 'selected' : '' }}>eSewa</option>
                    <option value="khalti" {{ request('provider') == 'khalti' ? 'selected' : '' }}>Khalti</option>
                    <option value="cod" {{ request('provider') == 'cod' ? 'selected' : '' }}>COD</option>
                </select>
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Order</th>
                <th>Provider</th>
                <th>Amount</th>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td>#{{ $payment->id }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $payment->order_id) }}">#{{ $payment->order->order_number ?? $payment->order_id }}</a><br>
                    <small>{{ $payment->order->user->name ?? 'Guest' }}</small>
                </td>
                <td>
                    @if($payment->provider == 'esewa')
                        <span style="color: #60bb46; font-weight: 700;">eSewa</span>
                    @elseif($payment->provider == 'khalti')
                        <span style="color: #5c2d91; font-weight: 700;">Khalti</span>
                    @else
                        <span>{{ ucfirst($payment->provider) }}</span>
                    @endif
                </td>
                <td><strong>Rs {{ number_format($payment->amount, 2) }}</strong></td>
                <td><small>{{ $payment->transaction_id ?? 'N/A' }}</small></td>
                <td>
                    <span class="badge badge-{{ $payment->status == 'completed' ? 'confirmed' : ($payment->status == 'failed' ? 'cancelled' : 'pending') }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
                <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">No payments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        {{ $payments->appends(request()->query())->links() }}
    </div>
</div>
@endsection
