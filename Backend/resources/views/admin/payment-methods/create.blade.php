@extends('admin.layout')

@section('title', 'Create Payment Method')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Payment Methods
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Add New Payment Method</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Code (Unique) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                   id="code" name="code" value="{{ old('code') }}" required
                                   placeholder="e.g., esewa, khalti, cod">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Lowercase, no spaces (e.g., esewa, khalti)</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="display_name">Display Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" name="display_name" value="{{ old('display_name') }}" required>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="2">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">Logo Image</label>
                            <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended: PNG with transparent background</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qr_code">QR Code Image</label>
                            <input type="file" class="form-control-file @error('qr_code') is-invalid @enderror" 
                                   id="qr_code" name="qr_code" accept="image/*">
                            @error('qr_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Upload QR code for payment</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account_name">Account Holder Name</label>
                            <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                                   id="account_name" name="account_name" value="{{ old('account_name') }}">
                            @error('account_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account_number">Account/Phone Number</label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                   id="account_number" name="account_number" value="{{ old('account_number') }}">
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="instructions">Payment Instructions</label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror" 
                              id="instructions" name="instructions" rows="3">{{ old('instructions') }}</textarea>
                    @error('instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Instructions shown to customers during checkout</small>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="extra_charge">Extra Charge</label>
                            <input type="number" step="0.01" class="form-control @error('extra_charge') is-invalid @enderror" 
                                   id="extra_charge" name="extra_charge" value="{{ old('extra_charge', 0) }}">
                            @error('extra_charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="extra_charge_type">Charge Type</label>
                            <select class="form-control @error('extra_charge_type') is-invalid @enderror" 
                                    id="extra_charge_type" name="extra_charge_type">
                                <option value="fixed" {{ old('extra_charge_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="percentage" {{ old('extra_charge_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                            @error('extra_charge_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="requires_verification" 
                               name="requires_verification" value="1" {{ old('requires_verification') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="requires_verification">Requires Manual Verification</label>
                    </div>
                    <small class="form-text text-muted">Check this if admin needs to verify payment manually</small>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Payment Method
                    </button>
                    <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
