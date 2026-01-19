@extends('admin.layout')

@section('title', 'Edit Product')
@section('header', 'Edit Product')
@section('subheader', 'Updating: ' . $product->name)

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div class="card">
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="6" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Price (Rs)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Discount Price (Optional)</label>
                    <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}" step="0.01">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Main Image (Keep empty to stay the same)</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                @if($product->image_url)
                    <div style="margin-top: 10px; display: flex; align-items: start; gap: 10px;">
                        <img src="{{ \Illuminate\Support\Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                        <div style="margin-top: 5px;">
                            <input type="checkbox" name="remove_main_image" id="remove_main_image" value="1">
                            <label for="remove_main_image" style="color: #dc3545; font-size: 13px;">Remove Image</label>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Gallery Images (Append new images)</label>
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                @if($product->gallery && is_array($product->gallery) && count($product->gallery) > 0)
                    <div style="margin-top: 10px;">
                        <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Select images to remove:</p>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            @foreach($product->gallery as $image)
                                <div style="display: flex; flex-direction: column; align-items: center; width: 80px;">
                                    <img src="{{ asset('storage/' . $image) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-bottom: 5px;">
                                    <div style="font-size: 12px;">
                                        <input type="checkbox" name="remove_gallery[]" value="{{ $image }}" id="gal_{{ loop->index }}">
                                        <label for="gal_{{ loop->index }}" style="color: #dc3545;">Remove</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Stock Quantity</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="form-group">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_available" id="is_available" {{ $product->is_available ? 'checked' : '' }}>
                    <label for="is_available" style="margin:0;">Available for order</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_active" id="is_active" {{ $product->is_active ? 'checked' : '' }}>
                    <label for="is_active" style="margin:0;">Active (Show on website)</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_featured" id="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                    <label for="is_featured" style="margin:0;">Featured Product</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_popular" id="is_popular" {{ $product->is_popular ? 'checked' : '' }}>
                    <label for="is_popular" style="margin:0;">Popular (Best Seller)</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="is_special" id="is_special" {{ $product->is_special ? 'checked' : '' }}>
                    <label for="is_special" style="margin:0;">Special Offer</label>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="width:100%; justify-content:center; margin-top:10px;">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
