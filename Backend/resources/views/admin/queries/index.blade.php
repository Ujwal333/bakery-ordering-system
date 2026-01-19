@extends('admin.layout')

@section('title', 'Manage Inquiries')
@section('header', 'Customer Queries')
@section('subheader', 'Handle contact form submissions and customer questions')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>From</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queries as $q)
            <tr style="background: {{ $q->status == 'unread' ? '#fff9f0' : '' }}">
                <td>{{ $q->created_at->format('M d, H:i') }}</td>
                <td><strong>{{ $q->name }}</strong><br><small>{{ $q->email }}</small></td>
                <td>{{ $q->subject }}</td>
                <td>
                    <span class="badge" style="background: {{ $q->status == 'unread' ? '#ff4757' : ($q->status == 'replied' ? '#2ecc71' : '#eee') }}; color: {{ $q->status == 'unread' || $q->status == 'replied' ? 'white' : '#333' }};">
                        {{ ucfirst($q->status) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.queries.show', $q) }}" class="btn btn-outline btn-sm" title="View Details"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.queries.destroy', $q) }}" method="POST" onsubmit="return confirm('Delete query?')" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
