@extends('admin.layout')

@section('title', 'Create Feature')

@section('content')
<div class="content-header">
    <h1>Create New Feature</h1>
    <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Features
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.features.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="icon">Icon (Font Awesome Class)</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon') }}" placeholder="e.g., fas fa-shopping-cart">
                        <small class="form-text text-muted">Visit <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a> for icon classes</small>
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Benefits (Optional)</label>
                        <div id="benefits-container">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="benefits[]" placeholder="Enter a benefit">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success" onclick="addBenefit()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <small class="form-text text-muted">Add multiple benefits that will be displayed as bullet points</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="image">Feature Image</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="image-preview" class="mt-2" style="display: none;">
                            <img id="preview" src="" alt="Preview" style="max-width: 100%; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Feature
                </button>
                <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addBenefit() {
    const container = document.getElementById('benefits-container');
    const newBenefit = document.createElement('div');
    newBenefit.className = 'input-group mb-2';
    newBenefit.innerHTML = `
        <input type="text" class="form-control" name="benefits[]" placeholder="Enter a benefit">
        <div class="input-group-append">
            <button type="button" class="btn btn-danger" onclick="this.closest('.input-group').remove()">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `;
    container.appendChild(newBenefit);
}

function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
