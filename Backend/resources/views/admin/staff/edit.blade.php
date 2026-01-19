@extends('admin.layout')

@section('title', 'Edit Staff')
@section('header', 'Edit Employee')
@section('subheader', 'Updating account for ' . $staff->name)

@section('content')
<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.staff.update', $staff) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="{{ $staff->username }}" disabled style="background: #f5f5f5;">
                <small class="text-muted">Username cannot be changed.</small>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">New Password (Optional)</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="staff" {{ old('role', $staff->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ old('role', $staff->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role', $staff->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Account Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ old('status', $staff->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $staff->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
