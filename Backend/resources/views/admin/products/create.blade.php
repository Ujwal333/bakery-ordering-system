@extends('admin.layout')

@section('content')
<div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Add New Product</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-container">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display:flex; gap: 30px; flex-wrap: wrap;">
            <!-- Left Column: Basic Info -->
            <div style="flex: 2; min-width: 300px;">
                <div class="form-group">
                    <label for="name">Product Name <span style="color: red;">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-group">
                    <label for="category_id">Category <span style="color: red;">*</span></label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description <span style="color: red;">*</span></label>
                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <!-- Pricing & Stock Row -->
                <div style="display: flex; gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="price">Price (Rs) <span style="color: red;">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label for="discount_price">Discount Price (Rs)</label>
                        <input type="number" name="discount_price" id="discount_price" class="form-control" step="0.01" min="0" value="{{ old('discount_price') }}">
                        <small style="color: #666;">Leave empty if no discount</small>
                        @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label for="stock">Stock <span style="color: red;">*</span></label>
                        <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ old('stock', 10) }}" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Product Details Row -->
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <div class="form-group" style="flex: 1; min-width: 150px;">
                        <label for="size">Size/Weight</label>
                        <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}" placeholder="e.g. 1kg, 6 pcs">
                    </div>
                    
                    <div class="form-group" style="flex: 1; min-width: 150px;">
                        <label for="flavor">Flavor</label>
                        <input type="text" name="flavor" id="flavor" class="form-control" value="{{ old('flavor') }}" placeholder="e.g. Vanilla">
                    </div>
                    
                    <div class="form-group" style="flex: 1; min-width: 150px;">
                        <label for="serves">Serves</label>
                        <input type="text" name="serves" id="serves" class="form-control" value="{{ old('serves') }}" placeholder="e.g. 4-6 people">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ingredients">Ingredients</label>
                    <textarea name="ingredients" id="ingredients" class="form-control" rows="2" placeholder="e.g. Flour, Sugar, Eggs...">{{ old('ingredients') }}</textarea>
                </div>
            </div>

            <!-- Right Column: Settings & Media -->
            <div style="flex: 1; min-width: 250px; background: #f8f9fa; padding: 20px; border-radius: 10px;">
                <h4 style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Settings</h4>
                
                <div class="form-group">
                    <label style="font-weight: 600;">Visibility & Tags</label>
                    
                    <div class="form-check" style="margin-bottom: 10px;">
                        <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', 'checked') ? 'checked' : '' }}>
                        <label for="is_available" style="cursor: pointer;">Available / Active</label>
                    </div>

                    <div class="form-check" style="margin-bottom: 10px;">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured" style="cursor: pointer;">Featured Product</label>
                    </div>

                    <div class="form-check" style="margin-bottom: 10px;">
                        <input type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}>
                        <label for="is_popular" style="cursor: pointer;">Popular Item</label>
                    </div>

                    <div class="form-check" style="margin-bottom: 10px;">
                        <input type="checkbox" name="is_special" id="is_special" value="1" {{ old('is_special') ? 'checked' : '' }}>
                        <label for="is_special" style="cursor: pointer;">Special Item</label>
                    </div>
                </div>

                <h4 style="margin: 20px 0; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Media</h4>
                
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <small style="color: #666;">Format: JPG, PNG. Max: 2MB</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div id="image-preview" style="margin-top: 10px; display: none;">
                    <img src="" alt="Preview" style="width: 100%; border-radius: 5px; border: 1px solid #ddd;">
                </div>
            </div>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 16px;">Create Product</button>
        </div>
    </form>
</div>

<script>
    // Image Preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.style.display = 'block';
                preview.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Simple Discount Validation
    const priceInput = document.getElementById('price');
    const discountInput = document.getElementById('discount_price');

    discountInput.addEventListener('change', function() {
        const price = parseFloat(priceInput.value);
        const discount = parseFloat(this.value);
        
        if (discount >= price) {
            alert('Discount price must be less than the regular price.');
            this.value = '';
        }
    });
</script>
@endsection
