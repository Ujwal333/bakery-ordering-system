@extends('admin.layout')

@section('title', 'Customers')
@section('header', 'Customer Management')
@section('subheader', 'View and manage your registered bakery customers')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">Registered Customers</h3>
        <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone..." value="{{ request('search') }}" style="width: 250px;">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Contact Info</th>
                <th>Total Orders</th>
                <th>Joined Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <strong>{{ $user->name }}</strong>
                    </div>
                </td>
                <td>
                    {{ $user->email }}<br>
                    <small style="color:#888;">{{ $user->phone }}</small>
                </td>
                <td>{{ $user->orders_count }} orders</td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $user->status == 'active' ? 'active' : 'inactive' }}">
                        {{ $user->status ?? 'active' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline btn-sm" title="View History">
                             <i class="fas fa-history"></i>
                        </a>
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn {{ $user->status == 'active' ? 'btn-danger' : 'btn-primary' }} btn-sm" style="min-width: 70px;">
                                {{ $user->status == 'active' ? 'Block' : 'Unblock' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="margin:0;" onsubmit="return confirm('Delete this customer?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline btn-sm" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
