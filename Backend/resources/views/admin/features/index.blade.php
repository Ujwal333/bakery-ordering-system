@extends('admin.layout')

@section('title', 'Manage Features')

@section('content')
<div class="content-header">
    <h1>Features Management</h1>
    <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Feature
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($features as $feature)
                <tr>
                    <td>
                        @if($feature->image_path)
                        <img src="{{ asset('storage/' . $feature->image_path) }}" alt="{{ $feature->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        @else
                        <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="color: #ccc;"></i>
                        </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $feature->title }}</strong><br>
                        <small class="text-muted">{{ Str::limit($feature->description, 50) }}</small>
                    </td>
                    <td>
                        @if($feature->icon)
                        <i class="{{ $feature->icon }}" style="font-size: 1.5rem; color: var(--primary);"></i>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $feature->sort_order }}</td>
                    <td>
                        <form action="{{ route('admin.features.toggle-active', $feature) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="badge {{ $feature->is_active ? 'badge-success' : 'badge-secondary' }}" style="border: none; cursor: pointer;">
                                {{ $feature->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this feature?');">
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
                    <td colspan="6" class="text-center">No features found. <a href="{{ route('admin.features.create') }}">Create one</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($features->hasPages())
        <div class="mt-3">
            {{ $features->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
