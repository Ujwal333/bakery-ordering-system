@extends('admin.layout')

@section('title', 'Manage Testimonials')
@section('header', 'Testimonials')
@section('subheader', 'Moderate and showcase customer feedback')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Content</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $t)
            <tr>
                <td><strong>{{ $t->customer_name }}</strong><br><small>{{ $t->designation }}</small></td>
                <td><p style="max-width: 400px; font-style: italic;">"{{ $t->content }}"</p></td>
                <td>
                    @for($i=1; $i<=5; $i++)
                        <i class="fas fa-star" style="color: {{ $i <= $t->rating ? '#f1c40f' : '#ddd' }}"></i>
                    @endfor
                </td>
                <td>
                    <span class="badge {{ $t->status == 'approved' ? 'badge-active' : 'badge-inactive' }}">
                        {{ $t->status }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <form action="{{ route('admin.testimonials.toggle-status', $t) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline btn-sm">
                                {{ $t->status == 'approved' ? 'Reject' : 'Approve' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Delete testimonial?')" style="margin:0;">
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
