@extends('admin.layout')

@section('title', 'Upload Image')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Gallery
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Upload New Image</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Image <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Max file size: 5MB. Recommended: 1200x800px or larger</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('category') is-invalid @enderror" 
                                    id="category" name="category">
                                <option value="">Select Category</option>
                                <option value="Cakes" {{ old('category') == 'Cakes' ? 'selected' : '' }}>Cakes</option>
                                <option value="Cupcakes" {{ old('category') == 'Cupcakes' ? 'selected' : '' }}>Cupcakes</option>
                                <option value="Cookies" {{ old('category') == 'Cookies' ? 'selected' : '' }}>Cookies</option>
                                <option value="Pastries" {{ old('category') == 'Pastries' ? 'selected' : '' }}>Pastries</option>
                                <option value="Breads" {{ old('category') == 'Breads' ? 'selected' : '' }}>Breads</option>
                                <option value="Custom" {{ old('category') == 'Custom' ? 'selected' : '' }}>Custom Cakes</option>
                                <option value="Events" {{ old('category') == 'Events' ? 'selected' : '' }}>Events</option>
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
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Lower numbers appear first</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" 
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_featured">Featured (Show on homepage)</label>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Image
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
