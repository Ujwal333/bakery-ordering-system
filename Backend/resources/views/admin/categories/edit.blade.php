@extends('admin.layout')

@section('title', 'Edit Category')
@section('header', 'Edit Category')
@section('subheader', 'Updating: ' . $category->name)

@section('content')
<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
            @error('name') <p style="color:var(--danger); font-size:12px; margin-top:5px;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ old('status', $category->is_active ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $category->is_active ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
