@extends('admin.layout')

@section('title', 'Careers & Vacancies')
@section('header', 'Career Management')
@section('subheader', 'Manage job vacancies and internships')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">Active Postings</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.jobs.applications') }}" class="btn btn-outline">
                <i class="fas fa-users"></i> View Applications
            </a>
            <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Post New Role
            </a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Department</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td><strong>{{ $job->title }}</strong></td>
                <td>{{ $job->type }}</td>
                <td>{{ $job->department }}</td>
                <td>{{ $job->deadline ? date('M d, Y', strtotime($job->deadline)) : 'No Deadline' }}</td>
                <td>
                    <span class="badge badge-{{ $job->is_active ? 'confirmed' : 'cancelled' }}">
                        {{ $job->is_active ? 'Active' : 'Closed' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-outline" style="padding: 5px 10px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Delete this posting?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 5px 10px; color: #e74c3c; border-color: #e74c3c;">
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
        {{ $jobs->links() }}
    </div>
</div>
@endsection
