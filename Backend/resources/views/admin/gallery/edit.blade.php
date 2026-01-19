@extends('admin.layout')

@section('title', 'Edit Image')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Gallery
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Edit Image: {{ $gallery->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="img-fluid rounded">
                    <small class="d-block text-muted mt-2">Current Image</small>
                    <div class="mt-2">
                        <input type="checkbox" name="remove_image" id="remove_image" value="1">
                        <label for="remove_image" style="color: #dc3545; font-size: 13px;">Remove Image</label>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Replace Image (Optional)</label>
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Leave empty to keep current image</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('category') is-invalid @enderror" 
                                    id="category" name="category">
                                <option value="">Select Category</option>
                                <option value="Cakes" {{ old('category', $gallery->category) == 'Cakes' ? 'selected' : '' }}>Cakes</option>
                                <option value="Cupcakes" {{ old('category', $gallery->category) == 'Cupcakes' ? 'selected' : '' }}>Cupcakes</option>
                                <option value="Cookies" {{ old('category', $gallery->category) == 'Cookies' ? 'selected' : '' }}>Cookies</option>
                                <option value="Pastries" {{ old('category', $gallery->category) == 'Pastries' ? 'selected' : '' }}>Pastries</option>
                                <option value="Breads" {{ old('category', $gallery->category) == 'Breads' ? 'selected' : '' }}>Breads</option>
                                <option value="Custom" {{ old('category', $gallery->category) == 'Custom' ? 'selected' : '' }}>Custom Cakes</option>
                                <option value="Events" {{ old('category', $gallery->category) == 'Events' ? 'selected' : '' }}>Events</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" 
                               {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_featured">Featured (Show on homepage)</label>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Image
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
