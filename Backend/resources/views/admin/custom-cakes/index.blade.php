@extends('admin.layout')

@section('content')
<div class="header-flex">
    <h2>Custom Cake Requests</h2>
</div>

<div class="card" style="margin-bottom: 20px;">
    <form action="{{ route('admin.custom-cakes.index') }}" method="GET" style="display: flex; gap: 15px; padding: 15px;">
        <input type="text" name="search" class="form-control" placeholder="Search Ref #, User, Cake Name" value="{{ request('search') }}" style="flex: 2;">
        
        <select name="status" class="form-control" style="flex: 1;">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.custom-cakes.index') }}" class="btn btn-secondary" style="text-decoration:none; display:flex; align-items:center;">Reset</a>
    </form>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Customer</th>
                <th>Cake Details</th>
                <th>Date Submitted</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customCakes as $request)
            <tr>
                <td><strong>{{ $request->reference_number }}</strong></td>
                <td>
                    {{ $request->user->name ?? 'Guest' }}<br>
                    <small style="color: #666;">{{ $request->user->email ?? '' }}</small>
                </td>
                <td>
                    <span style="font-weight: 500;">{{ $request->size }} {{ $request->flavor }}</span><br>
                    <small style="color: #666;">Delivery: {{ $request->delivery_date->format('d M Y') }}</small>
                </td>
                <td>{{ $request->created_at->format('d M Y, h:i A') }}</td>
                <td>
                    @php
                        $statusColors = [
                            'pending' => '#ff9800',
                            'approved' => '#4CAF50',
                            'rejected' => '#F44336',
                            'cancelled' => '#999',
                        ];
                        $color = $statusColors[$request->status] ?? '#999';
                    @endphp
                    <span class="badge" style="background-color: {{ $color }}; color: white;">
                        {{ ucfirst($request->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.custom-cakes.show', $request->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px;">
                    No custom cake requests found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="padding: 20px;">
        {{ $customCakes->appends(request()->query())->links() }}
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
