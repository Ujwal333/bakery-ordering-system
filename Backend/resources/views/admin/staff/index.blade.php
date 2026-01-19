@extends('admin.layout')

@section('title', 'Staff Management')
@section('header', 'Employees')
@section('subheader', 'Manage administrative access and roles')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>All Employees</h3>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Staff</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $member)
            <tr>
                <td>{{ $member->name }} <br> <small class="text-muted">{{ $member->email }}</small></td>
                <td>{{ $member->username }}</td>
                <td><span class="badge" style="background: #eee; color: #333;">{{ ucfirst($member->role) }}</span></td>
                <td>
                    <span class="badge {{ $member->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                        {{ $member->status }}
                    </span>
                </td>
                <td>{{ $member->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.staff.edit', $member) }}" class="btn btn-outline btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove staff member?')" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
