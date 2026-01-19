@extends('admin.layout')

@section('title', 'Add Product')
@section('header', 'Add New Product')
@section('subheader', 'Fill in the details to list a new item')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div class="card">
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Price (Rs)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Discount Price (Optional)</label>
                    <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price') }}" step="0.01">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label class="form-label">Gallery Images (Optional)</label>
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
            </div>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Stock Quantity</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
            </div>

            <div class="form-group">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_available" id="is_available" checked>
                    <label for="is_available" style="margin:0;">Available for order</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_active" id="is_active" checked>
                    <label for="is_active" style="margin:0;">Active (Show on website)</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_featured" id="is_featured">
                    <label for="is_featured" style="margin:0;">Featured Product</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <input type="checkbox" name="is_popular" id="is_popular">
                    <label for="is_popular" style="margin:0;">Popular (Best Seller)</label>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="is_special" id="is_special">
                    <label for="is_special" style="margin:0;">Special Offer</label>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Save Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="width:100%; justify-content:center; margin-top:10px;">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
