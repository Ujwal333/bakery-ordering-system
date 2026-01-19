@extends('admin.layout')

@section('title', 'Add Cake Option')
@section('header', 'Add Cake Option')
@section('subheader', 'Add new size, flavor, or type')

@section('content')
<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.cake-options.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Option Type</label>
            <select name="type" class="form-control" required>
                <option value="cake_type">Cake Type (e.g. Sponge, Mud)</option>
                <option value="size">Size (e.g. 8 inch, 12 inch)</option>
                <option value="flavor">Flavor (e.g. Vanilla, Chocolate)</option>
                <option value="frosting">Frosting (e.g. Buttercream)</option>
                <option value="decoration">Decoration (e.g. Fresh Flowers)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Red Velvet">
        </div>

        <div class="form-group">
            <label>Price Addition (Rs)</label>
            <input type="number" name="price" class="form-control" value="0" min="0">
            <small style="color: #666;">Set 0 if no extra cost</small>
        </div>

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock" class="form-control" value="100" min="0">
        </div>

        <div class="form-group">
            <label>Image (Optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" checked> Active
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Save Option</button>
    </form>
</div>
@endsection
