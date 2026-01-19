@extends('admin.layout')

@section('title', 'Logistic Partners')
@section('header', 'Logistics Management')
@section('subheader', 'Manage your delivery partners and assignments')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px;">
        <h3 style="margin:0;">Logistic Partners</h3>
        <a href="{{ route('admin.logistics.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Partner
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Partner Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Active Orders</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partners as $partner)
            <tr>
                <td><strong>{{ $partner->name }}</strong></td>
                <td>{{ $partner->contact_person ?? 'N/A' }}</td>
                <td>{{ $partner->phone ?? 'N/A' }}</td>
                <td><span class="badge badge-info">{{ $partner->orders_count }}</span></td>
                <td>
                    @if($partner->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.logistics.edit', $partner) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.logistics.destroy', $partner) }}" method="POST" onsubmit="return confirm('Remove this partner?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
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
