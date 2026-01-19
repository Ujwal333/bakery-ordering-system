@extends('admin.layout')

@section('title', 'Add Brand')
@section('header', 'Add New Brand')
@section('subheader', 'Register a new brand for your products')

@section('content')
<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Brand Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Premium Selection">
            @error('name')
                <div style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Brief about the brand...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Brand Logo (Optional)</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Brand
            </button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
