@extends('admin.layout')

@section('title', 'Activity Logs')
@section('header', 'System Activity Logs')
@section('subheader', 'Audit trail of administrative actions')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Module</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('M d, H:i:s') }}</td>
                <td><strong>{{ $log->admin->name ?? 'System' }}</strong></td>
                <td>{{ $log->action }}</td>
                <td><span style="background:#eee; padding:2px 8px; border-radius:4px; font-size:12px;">{{ $log->module }}</span></td>
                <td><small>{{ $log->description }}</small></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 25px;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
