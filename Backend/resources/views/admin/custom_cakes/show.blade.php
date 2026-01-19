@extends('admin.layout')

@section('title', 'Cake Request #' . $customCake->reference_number)
@section('header', 'Custom Cake Details')
@section('subheader', 'Reference: ' . $customCake->reference_number)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <div>
        <div class="card">
            <h3>Customization Details</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Cake Name</label>
                    <p><strong>{{ $customCake->cake_name }}</strong></p>
                </div>
                <div>
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Base Size</label>
                    <p><strong>{{ $customCake->size }}</strong></p>
                </div>
                <div>
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Flavor</label>
                    <p><strong>{{ $customCake->flavor }}</strong></p>
                </div>
                <div>
                    <label style="color:#888; font-size:12px; text-transform:uppercase;">Frosting</label>
                    <p><strong>{{ $customCake->frosting }}</strong></p>
                </div>
            </div>
            
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <label style="color:#888; font-size:12px; text-transform:uppercase;">Custom Message</label>
                <p style="font-size: 18px; color: var(--primary); font-family: 'Playfair Display', serif;">
                    "{{ $customCake->custom_message }}"
                </p>
            </div>

            @if($customCake->decorations)
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <label style="color:#888; font-size:12px; text-transform:uppercase;">Decorations selected</label>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                    @foreach($customCake->decorations as $decoration)
                        <span style="background: var(--light); padding: 5px 12px; border-radius: 20px; font-size: 13px;">{{ $decoration }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        @if($customCake->image_path)
        <div class="card">
            <h3>Reference Design</h3>
            <img src="{{ asset('storage/' . $customCake->image_path) }}" style="max-width: 100%; height: auto; max-height: 500px; object-fit: contain; border-radius: 12px; margin-top: 20px; border: 1px solid #eee;">
        </div>
        @endif
    </div>

    <div>
        <div class="card">
            <h3>Status Management</h3>
            <form action="{{ route('admin.custom-cakes.update-status', $customCake) }}" method="POST" style="margin-top: 20px;">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <select name="status" class="form-control" style="background: var(--light);">
                        <option value="pending" {{ $customCake->status == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="confirmed" {{ $customCake->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="in_progress" {{ $customCake->status == 'in_progress' ? 'selected' : '' }}>Baking / In Progress</option>
                        <option value="completed" {{ $customCake->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $customCake->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Status</button>
            </form>
        </div>

        <div class="card">
            <h3>Price Breakdown</h3>
            <div style="margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Base Size Price:</span>
                    <span>Rs {{ number_format($customCake->size_price) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Flavor Option:</span>
                    <span>Rs {{ number_format($customCake->flavor_price) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Frosting:</span>
                    <span>Rs {{ number_format($customCake->frosting_price) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Decorations:</span>
                    <span>Rs {{ number_format($customCake->decorations_price) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 20px; font-weight: bold; border-top: 2px solid #eee; padding-top: 15px;">
                    <span>Total Estimated:</span>
                    <span style="color: var(--primary);">Rs {{ number_format($customCake->total_price) }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <h3>Delivery Info</h3>
            <p>Date: <strong>{{ $customCake->delivery_date->format('M d, Y') }}</strong></p>
            <p>Time: <strong>{{ $customCake->delivery_time }}</strong></p>
        </div>
    </div>
</div>
@endsection
