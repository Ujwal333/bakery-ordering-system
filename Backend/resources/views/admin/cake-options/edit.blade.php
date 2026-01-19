@extends('admin.layout')

@section('title', 'Edit Cake Option')
@section('header', 'Edit Cake Option')
@section('subheader', 'Update customization option')

@section('content')
<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.cake-options.update', $cakeOption) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Option Type</label>
            <select name="type" class="form-control" required>
                <option value="cake_type" {{ $cakeOption->type == 'cake_type' ? 'selected' : '' }}>Cake Type</option>
                <option value="size" {{ $cakeOption->type == 'size' ? 'selected' : '' }}>Size</option>
                <option value="flavor" {{ $cakeOption->type == 'flavor' ? 'selected' : '' }}>Flavor</option>
                <option value="frosting" {{ $cakeOption->type == 'frosting' ? 'selected' : '' }}>Frosting</option>
                <option value="decoration" {{ $cakeOption->type == 'decoration' ? 'selected' : '' }}>Decoration</option>
            </select>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $cakeOption->name }}" required>
        </div>

        <div class="form-group">
            <label>Price Addition (Rs)</label>
            <input type="number" name="price" class="form-control" value="{{ $cakeOption->price }}" min="0">
        </div>

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock" class="form-control" value="{{ $cakeOption->stock ?? 100 }}" min="0">
        </div>

        <div class="form-group">
            <label>Image</label>
            @if($cakeOption->image_path)
                <div style="margin-bottom: 10px; display: flex; align-items: start; gap: 10px;">
                    <img src="{{ asset('storage/' . $cakeOption->image_path) }}" alt="Current Image" style="height: 60px; border-radius: 5px;">
                    <div style="margin-top: 5px;">
                        <input type="checkbox" name="remove_image" id="remove_image" value="1">
                        <label for="remove_image" style="color: #dc3545; font-size: 13px;">Remove Image</label>
                    </div>
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ $cakeOption->is_active ? 'checked' : '' }}> Active
            </label>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary">Update Option</button>
            <a href="{{ route('admin.cake-options.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
