@extends('layouts.app')

@section('title', 'Order Confirmed - Cinnamon Bakery')

@section('styles')
<style>
    .confirmation-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 40px 20px;
    }

    .confirmation-card {
        background: white;
        border-radius: 24px;
        padding: 50px 40px;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        text-align: center;
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        animation: scaleIn 0.6s ease-out 0.2s both;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-icon i {
        font-size: 40px;
        color: white;
    }

    .confirmation-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #2d3748;
        margin-bottom: 15px;
    }

    .confirmation-subtitle {
        color: #718096;
        font-size: 1.1rem;
        margin-bottom: 40px;
    }

    .order-id-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 16px;
        margin-bottom: 30px;
    }

    .order-id-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .order-id-value {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 2px;
        font-family: 'Courier New', monospace;
    }

    .copy-btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 15px;
        transition: all 0.3s;
    }

    .copy-btn:hover {
        background: rgba(255,255,255,0.3);
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
        text-align: left;
    }

    .info-item {
        background: #f7fafc;
        padding: 15px;
        border-radius: 12px;
    }

    .info-label {
        font-size: 0.85rem;
        color: #718096;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: 600;
        color: #2d3748;
        font-size: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 14px 30px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-secondary:hover {
        background: #f7fafc;
    }

    .important-note {
        background: #fff5f5;
        border-left: 4px solid #fc8181;
        padding: 15px;
        border-radius: 8px;
        margin-top: 30px;
        text-align: left;
    }

    .important-note strong {
        color: #c53030;
    }

    @media (max-width: 600px) {
        .confirmation-card {
            padding: 40px 25px;
        }

        .order-id-value {
            font-size: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="confirmation-wrapper">
    <div class="confirmation-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1 class="confirmation-title">Order Confirmed!</h1>
        <p class="confirmation-subtitle">Thank you for your order. We've received it and will start preparing your delicious treats!</p>

        <div class="order-id-box">
            <div class="order-id-label">Your Order ID</div>
            <div class="order-id-value" id="order-id">{{ $orderNumber ?? 'Loading...' }}</div>
            <button class="copy-btn" onclick="copyOrderId()">
                <i class="fas fa-copy"></i> Copy Order ID
            </button>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Phone Number</div>
                <div class="info-value">{{ $phone ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Payment Method</div>
                <div class="info-value">{{ strtoupper($paymentMethod ?? 'COD') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Delivery Date</div>
                <div class="info-value">{{ $deliveryDate ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Amount</div>
                <div class="info-value">Rs {{ number_format($totalAmount ?? 0) }}</div>
            </div>
        </div>

        <div class="important-note">
            <strong><i class="fas fa-exclamation-circle"></i> Important:</strong> 
            Please save your <strong>Order ID</strong> and <strong>Phone Number</strong>. You'll need both to track your order.
        </div>

        <div class="action-buttons" style="margin-top: 30px;">
            <a href="/order-tracking" class="btn btn-primary">
                <i class="fas fa-map-marker-alt"></i> Track Order
            </a>
            @if($orderId)
            <a href="{{ route('orders.invoice', $orderId) }}" class="btn btn-secondary" target="_blank" style="background: #5e4026; color: white; border: none;">
                <i class="fas fa-file-invoice"></i> Download Slip
            </a>
            @endif
            <a href="/menu" class="btn btn-secondary">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
            </a>
        </div>

        <p style="margin-top: 30px; color: #718096; font-size: 0.9rem;">
            A confirmation has been sent to your registered email.
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyOrderId() {
        const orderIdText = document.getElementById('order-id').innerText;
        navigator.clipboard.writeText(orderIdText).then(() => {
            const btn = document.querySelector('.copy-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
            btn.style.background = 'rgba(72, 187, 120, 0.3)';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = 'rgba(255,255,255,0.2)';
            }, 2000);
            
            showNotification('Order ID copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy:', err);
            showNotification('Failed to copy. Please copy manually.', 'error');
        });
    }

    // Auto-fill tracking form if user clicks "Track Order"
    document.querySelector('a[href="/order-tracking"]')?.addEventListener('click', function(e) {
        const orderId = document.getElementById('order-id').innerText;
        sessionStorage.setItem('pendingOrderId', orderId);
    });
</script>
@endsection
