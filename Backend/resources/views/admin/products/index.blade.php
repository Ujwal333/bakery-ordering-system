@extends('admin.layout')

@section('title', 'Products')
@section('header', 'Product Management')
@section('subheader', 'Manage your bakery items and inventory')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">All Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" 
                         alt="{{ $product->name }}" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                </td>
                <td>
                    <strong>{{ $product->name }}</strong>
                    @if($product->is_featured)
                        <span style="font-size: 10px; background: #fff3cd; color: #856404; padding: 2px 6px; border-radius: 4px; margin-left: 5px;">Featured</span>
                    @endif
                </td>
                <td>{{ $product->category->name }}</td>
                <td>
                    @if($product->discount_price)
                        <span style="text-decoration: line-through; color: #999; font-size: 12px;">Rs {{ number_format($product->price) }}</span><br>
                        <strong>Rs {{ number_format($product->discount_price) }}</strong>
                    @else
                        <strong>Rs {{ number_format($product->price) }}</strong>
                    @endif
                </td>
                <td>
                    <span style="color: {{ $product->stock < 10 ? 'var(--danger)' : 'inherit' }}">
                        {{ $product->stock }} in stock
                    </span>
                </td>
                <td>
                    <span class="badge {{ $product->is_available ? 'badge-active' : 'badge-inactive' }}">
                        {{ $product->is_available ? 'Available' : 'Hidden' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Move product to trash?')" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline btn-sm" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
