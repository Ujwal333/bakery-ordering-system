@extends('admin.layout')

@section('content')
<div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Edit Category: {{ $category->name }}</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-container" style="max-width: 800px;">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Category Name <span style="color: red;">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="slug">Slug (Auto-updated)</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->slug) }}" style="background-color: #f8f9fa;" readonly>
            <small style="color: #666;">The slug is used in the URL.</small>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Category Image</label>
            @if($category->image)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" style="height: 100px; border-radius: 5px;">
                    <p><small>Current Image</small></p>
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small style="color: #666;">Leave empty to keep current image. Recommended size: 800x600px</small>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group form-check">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
            <label for="is_active" style="margin-bottom: 0; cursor: pointer;">Active (Visible on website)</label>
        </div>
        
        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Update Category</button>
        </div>
    </form>
</div>

<script>
    // Simple slug generator
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        const val = this.value;
        const slug = val
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
            
        slugInput.value = slug;
    });
</script>
@endsection
