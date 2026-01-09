@extends('admin.layout')

@section('content')
<div class="header-flex">
    <h2>Bakery Events</h2>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Event
    </a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Event Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    @if($event->image_path)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                    @else
                        <div style="width: 60px; height: 40px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $event->title }}</strong><br>
                    <small style="color: #666;">{{ Str::limit($event->description, 50) }}</small>
                </td>
                <td>{{ $event->event_date->format('d M Y') }}</td>
                <td>
                    <span class="badge" style="background-color: {{ $event->is_active ? '#4CAF50' : '#999' }}; color: white;">
                        {{ $event->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?')">
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

<style>
    .badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }
</style>
@endsection
