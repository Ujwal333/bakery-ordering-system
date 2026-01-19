@extends('admin.layout')

@section('title', 'Newsletter Subscribers')
@section('header', 'Subscribers')
@section('subheader', 'Email list for marketing and updates')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Email List</h3>
        <button class="btn btn-outline"><i class="fas fa-download"></i> Export CSV</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Email Address</th>
                <th>Status</th>
                <th>Subscribed On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscribers as $s)
            <tr>
                <td><strong>{{ $s->email }}</strong></td>
                <td>
                    <span class="badge {{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $s->is_active ? 'Active' : 'Unsubscribed' }}
                    </span>
                </td>
                <td>{{ $s->created_at->format('M d, Y') }}</td>
                <td>
                    <form action="{{ route('admin.subscribers.destroy', $s) }}" method="POST" onsubmit="return confirm('Remove subscriber?')" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-outline btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
