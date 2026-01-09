@extends('admin.layout')

@section('content')
<div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Category Management</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Category
    </a>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>{{ $category->order }}</td>
                <td>
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                    @else
                        <span style="color: #ccc;">No Image</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $category->name }}</strong>
                    @if($category->description)
                        <br><small style="color: #777;">{{ Str::limit($category->description, 50) }}</small>
                    @endif
                </td>
                <td>{{ $category->slug }}</td>
                <td>
                    <form action="{{ route('admin.categories.toggle', $category->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-success' : 'btn-secondary' }}" 
                            style="background: {{ $category->is_active ? '#28a745' : '#6c757d' }}; color: white; border: none; padding: 5px 10px; border-radius: 20px; cursor: pointer;">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </td>
                <td>{{ $category->products_count }}</td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                    <p>No categories found.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm" style="margin-top: 10px;">Create your first category</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
