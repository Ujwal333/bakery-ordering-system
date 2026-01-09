@extends('admin.layout')

@section('content')
<div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Product Management</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

<div class="table-responsive">
    <table class="table">
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
            @forelse($products as $product)
            <tr>
                <td>
                    @if($product->image_url)
                        {{-- Handle both full URLs (DB Seed) and relative paths (Storage) --}}
                        @php
                            $imgSrc = Str::startsWith($product->image_url, 'http') 
                                ? $product->image_url 
                                : asset('storage/' . $product->image_url);
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                    @else
                        <span style="color: #ccc;">No Image</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $product->name }}</strong>
                    <div>
                        @if($product->is_featured) <span style="font-size: 10px; background: #e3f2fd; color: #0d47a1; padding: 2px 5px; border-radius: 3px;">Featured</span> @endif
                        @if($product->is_popular) <span style="font-size: 10px; background: #e8f5e9; color: #1b5e20; padding: 2px 5px; border-radius: 3px;">Popular</span> @endif
                        @if($product->is_special) <span style="font-size: 10px; background: #fff3e0; color: #e65100; padding: 2px 5px; border-radius: 3px;">Special</span> @endif
                    </div>
                </td>
                <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                <td>
                    @if($product->discount_price)
                        <span style="text-decoration: line-through; color: #999;">Rs {{ $product->price }}</span>
                        <br>
                        <span style="color: #d32f2f; font-weight: bold;">Rs {{ $product->discount_price }}</span>
                    @else
                        Rs {{ $product->price }}
                    @endif
                </td>
                <td>
                    @if($product->stock < 5)
                        <span style="color: red; font-weight: bold;">{{ $product->stock }}</span>
                    @else
                        {{ $product->stock }}
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm" 
                            style="background: {{ $product->is_available ? '#28a745' : '#6c757d' }}; color: white; border: none; padding: 5px 10px; border-radius: 20px; cursor: pointer;">
                            {{ $product->is_available ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px;">
                    <p>No products found.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm" style="margin-top: 10px;">Create your first product</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px;">
    {{ $products->links() }}
</div>
@endsection
