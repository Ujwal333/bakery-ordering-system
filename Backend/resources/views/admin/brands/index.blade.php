@extends('admin.layout')

@section('title', 'Manage Brands')
@section('header', 'Brands / Vendors')
@section('subheader', 'Categorize products by brand or supplier')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">All Brands</h3>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Brand
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>
                    @if($brand->logo)
                        <img src="{{ Str::startsWith($brand->logo, 'http') ? $brand->logo : asset('storage/' . $brand->logo) }}" 
                             alt="{{ $brand->name }}" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    @else
                        <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa;">
                            <i class="fas fa-tag"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $brand->name }}</strong>
                    @if($brand->description)
                        <br><small style="color: #666;">{{ Str::limit($brand->description, 50) }}</small>
                    @endif
                </td>
                <td>
                    @php
                        $totalStock = $brand->products->sum('stock');
                    @endphp
                    <span style="color: {{ $totalStock < 10 ? 'var(--danger)' : 'inherit' }}">
                        {{ $totalStock }} items
                    </span>
                </td>
                <td>{{ $brand->slug }}</td>
                <td>
                    <span class="badge {{ $brand->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $brand->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-outline btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Delete brand?')" style="margin:0;">
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
