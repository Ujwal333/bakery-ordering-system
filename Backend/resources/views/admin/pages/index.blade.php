@extends('admin.layout')

@section('title', 'CMS Pages')
@section('header', 'Pages')
@section('subheader', 'Manage website content pages')

@section('content')
<div class="card">
    <div style="margin-bottom: 20px; display: flex; justify-content: flex-end;">
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Page</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td><code>/{{ $page->slug }}</code></td>
                <td>
                    @if($page->is_active)
                        <span class="badge badge-active">Active</span>
                    @else
                        <span class="badge badge-inactive">Inactive</span>
                    @endif
                </td>
                <td>{{ $page->updated_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline btn-sm" style="padding: 5px 10px; margin-right: 5px;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this page?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-outline btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding: 30px; color: #888;">No pages found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        {{ $pages->links() }}
    </div>
</div>
@endsection
