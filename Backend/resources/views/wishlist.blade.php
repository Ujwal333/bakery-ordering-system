@extends('layouts.app')

@section('title', 'My Saved Items - Cinnamon Bakery')

@section('styles')
<style>
    .wishlist-container {
        padding: 50px 0;
        background: #fdf1e6;
        min-height: 80vh;
    }
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .wish-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        text-align: center;
        position: relative;
    }
    .wish-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 15px;
    }
    .remove-wish {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255,255,255,0.9);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff4757;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    .remove-wish:hover {
        background: #ff4757;
        color: white;
    }
    .old-price {
        font-size: 14px;
        color: #8d6e63;
        text-decoration: line-through;
        font-weight: 500;
        margin-right: 10px;
    }
    .current-price {
        color: var(--primary);
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<section class="wishlist-container">
    <div class="container">
        <div style="text-align: center;">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary);">Favorite Treats</h1>
            <p style="color: #666;">Items you've saved for later. Indulge when you're ready!</p>
        </div>

        <div class="wishlist-grid">
            @forelse($savedItems as $item)
            <div class="wish-card" id="wish-{{ $item->product->id }}">
                <button class="remove-wish" onclick="toggleWishlist({{ $item->product->id }})">
                    <i class="fas fa-trash"></i>
                </button>
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 10px;">{{ $item->product->name }}</h3>
                <div style="margin-bottom: 20px;">
                    @if($item->product->discount_price > 0)
                        <span class="old-price">Rs. {{ number_format($item->product->price, 0) }}</span>
                        <span class="current-price">Rs. {{ number_format($item->product->discount_price, 0) }}</span>
                    @else
                        <span class="current-price">Rs. {{ number_format($item->product->price, 0) }}</span>
                    @endif
                </div>
                <div style="display: flex; flex-direction: column; width: 100%; gap: 5px;">
                    @if($item->product->stock <= 0)
                        <span style="color: #dc3545; font-size: 11px; font-weight: 600;">Out of Stock</span>
                        <button class="btn" disabled style="background: #ccc; cursor: not-allowed; width: 100%;">Add to Cart</button>
                    @else
                        @if($item->product->stock < 5)
                            <span style="color: #e67e22; font-size: 10px; font-weight: 600;">Only {{ $item->product->stock }} left!</span>
                        @endif
                        <button class="btn" onclick="addToCart({{ $item->product->id }}, '{{ $item->product->name }}', {{ $finalPrice }})" style="width: 100%;">Add to Cart</button>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 100px 0;">
                <i class="fas fa-heart" style="font-size: 5rem; color: #ddd; margin-bottom: 20px;"></i>
                <h3>Your wishlist is empty!</h3>
                <p>Browse our menu and save your favorite treats here.</p>
                <a href="{{ route('browse-menu') }}" class="btn" style="display: inline-block; margin-top: 20px;">Start Browsing</a>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    async function toggleWishlist(productId) {
        try {
            const response = await fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            });
            const data = await response.json();
            if (data.status === 'removed') {
                document.getElementById(`wish-${productId}`).remove();
                if (document.querySelectorAll('.wish-card').length === 0) {
                    location.reload();
                }
                showNotification('Item removed from favorites');
            }
        } catch (e) { console.error(e); }
    }
</script>
@endsection
