@extends('admin.layout')

@section('title', 'Manage Help Content')

@section('content')
<div class="content-header">
    <h1>Help Center Management</h1>
    <a href="{{ route('admin.help-contents.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Content
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
                    <th>Type</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($helpContents as $content)
                <tr>
                    <td>
                        <span class="badge badge-{{ $content->type == 'faq' ? 'info' : 'warning' }}">
                            {{ strtoupper($content->type) }}
                        </span>
                    </td>
                    <td>
                        <strong>{{ $content->title }}</strong><br>
                        <small class="text-muted">{{ Str::limit($content->content, 60) }}</small>
                    </td>
                    <td>{{ $content->category ? ucfirst($content->category) : '-' }}</td>
                    <td>{{ $content->sort_order }}</td>
                    <td>
                        <form action="{{ route('admin.help-contents.toggle-active', $content) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="badge {{ $content->is_active ? 'badge-success' : 'badge-secondary' }}" style="border: none; cursor: pointer;">
                                {{ $content->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.help-contents.edit', $content) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.help-contents.destroy', $content) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
                    <td colspan="6" class="text-center">No help content found. <a href="{{ route('admin.help-contents.create') }}">Create one</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($helpContents->hasPages())
        <div class="mt-3">
            {{ $helpContents->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
