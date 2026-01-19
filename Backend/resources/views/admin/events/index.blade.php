@extends('admin.layout')

@section('title', 'Bakery Events')
@section('header', 'Events')
@section('subheader', 'Promote seasonal items and bakery workshops')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">Active Events</h3>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Event
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Event Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    @if($event->image_path)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                    @else
                        <div style="width: 60px; height: 40px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $event->title }}</strong>
                </td>
                <td>{{ $event->event_date->format('M d, Y') }}</td>
                <td>
                    <span class="badge {{ $event->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $event->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-outline btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete event?')" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px;">
                    No events found. <a href="{{ route('admin.events.create') }}">Create your first event!</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="padding: 20px;">
        {{ $events->links() }}
    </div>
</div>

@endsection
