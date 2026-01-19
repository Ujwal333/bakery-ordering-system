@extends('admin.layout')

@section('title', 'Query Details')
@section('header', 'Inquiry Details')
@section('subheader', 'Reading query from ' . $query->name)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <div class="card">
        <h3>Message</h3>
        <div style="background: var(--light); padding: 20px; border-radius: 12px; margin-top: 20px;">
            <p style="white-space: pre-wrap;">{{ $query->message }}</p>
        </div>
        
        <form action="{{ route('admin.queries.update-status', $query) }}" method="POST" style="margin-top: 30px;">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label class="form-label">Internal Admin Notes</label>
                <textarea name="admin_note" class="form-control" rows="5" placeholder="Record your response or internal notes...">{{ $query->admin_note }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="read" {{ $query->status == 'read' ? 'selected' : '' }}>Mark as Read</option>
                    <option value="replied" {{ $query->status == 'replied' ? 'selected' : '' }}>Mark as Replied</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <div class="card">
        <h3>Contact Info</h3>
        <p>Name: <strong>{{ $query->name }}</strong></p>
        <p>Email: <strong>{{ $query->email }}</strong></p>
        <p>Phone: <strong>{{ $query->phone ?? 'Not provided' }}</strong></p>
        <p>Date: <strong>{{ $query->created_at->format('M d, Y H:i') }}</strong></p>
    </div>
</div>
@endsection
