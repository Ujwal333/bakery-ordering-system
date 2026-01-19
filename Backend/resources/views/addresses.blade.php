@extends('layouts.app')

@section('title', 'My Addresses - Cinnamon Bakery')

@section('styles')
<style>
    .addresses-container {
        padding: 50px 0;
        background: #fdf1e6;
        min-height: 80vh;
    }
    .address-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .address-type {
        background: var(--accent2);
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 10px;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<section class="addresses-container">
    <div class="container" style="max-width: 800px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--secondary);">Stored Addresses</h1>
            <p style="color: #666;">Manage your delivery locations for faster checkout.</p>
        </div>

        @forelse($addresses as $address)
        <div class="address-card">
            <div>
                <span class="address-type">{{ strtoupper($address->type) }}</span>
                <h3>{{ $address->address }}</h3>
                <p style="color: #666;">{{ $address->city }}</p>
                <p style="color: #888; font-size: 14px;"><i class="fas fa-phone"></i> {{ $address->phone }}</p>
            </div>
            @if($address->is_default)
                <span style="color: var(--primary); font-weight: 700;"><i class="fas fa-check-circle"></i> Default</span>
            @endif
        </div>
        @empty
        <div style="text-align: center; padding: 100px 0;">
            <i class="fas fa-map-marked-alt" style="font-size: 5rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3>No addresses saved!</h3>
            <p>Save your home or work address for a smoother delivery experience.</p>
        </div>
        @endforelse

        <div style="text-align: center; margin-top: 30px;">
            <button class="btn" onclick="showNotification('Address adding feature coming soon!', 'info')">Add New Address</button>
        </div>
    </div>
</section>
@endsection
