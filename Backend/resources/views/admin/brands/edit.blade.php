@extends('admin.layout')

@section('title', 'Edit Brand')
@section('header', 'Edit Brand')
@section('subheader', 'Update brand details')

@section('content')
<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Brand Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}" required>
            @error('name')
                <div style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $brand->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Brand Logo</label>
            @if($brand->logo)
                <div style="margin-bottom: 15px;">
                    <img src="{{ Str::startsWith($brand->logo, 'http') ? $brand->logo : asset('storage/' . $brand->logo) }}" alt="Current Logo" style="height: 80px; width: 80px; object-fit: contain; border-radius: 8px; border: 1px solid #eee; padding: 5px;">
                </div>
            @endif
            <input type="file" name="logo" class="form-control" accept="image/*">
            <small style="color: #888;">Leave empty to keep current logo</small>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ (old('status') ?? ($brand->is_active ? 'active' : 'inactive')) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (old('status') ?? ($brand->is_active ? 'active' : 'inactive')) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Brand
            </button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
