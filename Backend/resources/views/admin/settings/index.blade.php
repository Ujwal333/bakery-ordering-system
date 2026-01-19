@extends('admin.layout')

@section('title', 'Global Settings')

@section('content')
<div class="content-header">
    <h1>Bakery Settings</h1>
    <p class="text-muted">Configure site-wide preferences and business rules</p>
</div>
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- General Info -->
        <div class="card">
            <h3>General Info</h3>
            <div class="form-group">
                <label class="form-label">Bakery Name</label>
                <input type="text" name="bakery_name" class="form-control" value="{{ $settings['bakery_name'] ?? 'Cinnamon Bakery' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Bakery Logo</label>
                <input type="file" name="bakery_logo" class="form-control" accept="image/*">
                @if(isset($settings['bakery_logo']))
                    <img src="{{ asset('storage/' . $settings['bakery_logo']) }}" style="height: 50px; margin-top: 10px;">
                @endif
            </div>
            <div class="form-group">
                <label class="form-label">Contact Address</label>
                <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? 'Sano Bharayang, Kathmandu, Nepal' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'info@cinnamonbakery.com' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Contact Phone</label>
                <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '+977 9769349551' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Opening Hours</label>
                <input type="text" name="contact_hours" class="form-control" value="{{ $settings['contact_hours'] ?? 'Open Daily: 8AM - 8PM' }}">
            </div>
        </div>

        <!-- Business Rules -->
        <div class="card">
            <h3>Business Rules</h3>
            <div class="form-group">
                <label class="form-label">Delivery Charge (Rs)</label>
                <input type="number" name="delivery_charge" class="form-control" value="{{ $settings['delivery_charge'] ?? 100 }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tax / VAT (%)</label>
                <input type="number" name="tax_percentage" class="form-control" value="{{ $settings['tax_percentage'] ?? 13 }}">
            </div>
            <div class="form-group">
                <label class="form-label">Min. Order for Free Delivery (Rs)</label>
                <input type="number" name="min_order_free_delivery" class="form-control" value="{{ $settings['min_order_free_delivery'] ?? 2000 }}">
            </div>
            <div class="form-group">
                <label class="form-label">Business Status</label>
                <select name="maintenance_mode" class="form-control">
                    <option value="0" {{ ($settings['maintenance_mode'] ?? '0') == '0' ? 'selected' : '' }}>Open for Business</option>
                    <option value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'selected' : '' }}>Maintenance Mode (Closed)</option>
                </select>
            </div>
        </div>

        <!-- Social Media -->
        <div class="card">
            <h3>Social Media</h3>
            <div class="form-group">
                <label class="form-label">Facebook URL</label>
                <input type="text" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '#' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Instagram URL</label>
                <input type="text" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? '#' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Twitter / X URL</label>
                <input type="text" name="social_twitter" class="form-control" value="{{ $settings['social_twitter'] ?? '#' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Pinterest URL</label>
                <input type="text" name="social_pinterest" class="form-control" value="{{ $settings['social_pinterest'] ?? '#' }}">
            </div>
        </div>

        <!-- Footer Content -->
        <div class="card">
            <h3>Footer Content</h3>
            <div class="form-group">
                <label class="form-label">Footer Description (About)</label>
                <textarea name="footer_description" class="form-control" rows="3">{{ $settings['footer_description'] ?? 'Artisan bakery crafting delicious treats since 2022. Quality ingredients, traditional methods, modern flavors.' }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Newsletter Text</label>
                <textarea name="newsletter_text" class="form-control" rows="2">{{ $settings['newsletter_text'] ?? 'Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.' }}</textarea>
            </div>
        </div>
    </div>

    <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
        <button type="submit" class="btn btn-primary" style="min-width: 200px; justify-content: center;">Save All Settings</button>
    </div>
</form>
@endsection
