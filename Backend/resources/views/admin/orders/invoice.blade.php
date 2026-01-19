<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Cinnamon Bakery</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 40px; }
        .invoice-box { max-width: 800px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 40px; }
        .logo { font-size: 28px; font-weight: bold; color: #D4A76A; }
        .invoice-details { text-align: right; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .section-title { font-size: 14px; text-transform: uppercase; color: #888; border-bottom: 1px solid #eee; padding-bottom: 8px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th { background: #f9f9f9; text-align: left; padding: 12px; border-bottom: 2px solid #eee; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .total-section { text-align: right; }
        .total-row { display: flex; justify-content: flex-end; gap: 20px; margin-bottom: 10px; }
        .footer { text-align: center; margin-top: 60px; color: #888; font-size: 12px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-box">
        <div class="header">
            <div class="logo">CINNAMON BAKERY</div>
            <div class="invoice-details">
                <h1 style="margin:0; font-size:24px;">INVOICE</h1>
                <p style="margin:5px 0;">Order ID: #{{ $order->id }}</p>
                <p style="margin:5px 0;">Date: {{ $order->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid">
            <div>
                <div class="section-title">Billing From</div>
                <p><strong>Cinnamon Bakery Nepal</strong></p>
                <p>Kathmandu, Nepal</p>
                <p>Phone: +977 123456789</p>
                <p>Email: orders@cinnamonbakery.com</p>
            </div>
            <div>
                <div class="section-title">Billing To</div>
                <p><strong>{{ $order->user->name ?? $order->recipient_name }}</strong></p>
                <p>{{ $order->shipping_address }}, {{ $order->area }}</p>
                <p>{{ $order->city }}, Nepal</p>
                <p>Phone: {{ $order->user->phone ?? $order->phone }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th style="text-align:right;">Price</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}
                        @if($item->custom_message)
                            <br><small style="color:#666;">Message: "{{ $item->custom_message }}"</small>
                        @endif
                    </td>
                    <td style="text-align:right;">Rs {{ number_format($item->unit_price) }}</td>
                    <td style="text-align:center;">{{ $item->quantity }}</td>
                    <td style="text-align:right;">Rs {{ number_format($item->unit_price * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span style="min-width: 100px;">Rs {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="total-row">
                <span>Delivery Charge:</span>
                <span style="min-width: 100px;">Rs {{ number_format($order->delivery_charge) }}</span>
            </div>
            <div class="total-row" style="font-size: 20px; font-weight: bold; color: #D4A76A; border-top: 2px solid #eee; padding-top: 15px;">
                <span>Total Amount:</span>
                <span style="min-width: 100px;">Rs {{ number_format($order->total_amount) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Cinnamon Bakery!</p>
            <p>Terms: All items are non-refundable after baking starts.</p>
        </div>

        <div class="no-print" style="margin-top: 40px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #D4A76A; color: white; border: none; border-radius: 5px;">Print Now</button>
        </div>
    </div>
</body>
</html>
