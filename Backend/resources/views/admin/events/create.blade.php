@extends('admin.layout')

@section('content')
<div class="header-flex">
    <h2>Add New Event</h2>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Events
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; padding: 30px;">
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="Enter event title">
        </div>

        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description (About page content)</label>
            <textarea name="description" id="description" class="form-control" rows="5" required placeholder="Describe the event..."></textarea>
        </div>

        <div class="form-group">
            <label for="image">Event Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small style="color: #666;">Recommended size: 800x600px. Max 2MB.</small>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
            <label for="is_active" style="margin-bottom: 0;">Show on About page</label>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 20px;">
            <i class="fas fa-save"></i> Save Event
        </button>
    </form>
</div>
@endsection
