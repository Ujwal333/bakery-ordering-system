@extends('admin.layout')

@section('title', 'Job Applications')
@section('header', 'Job Applications')
@section('subheader', 'Review candidates who applied for vacancies/internships')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Applied For</th>
                <th>Contact</th>
                <th>Resume</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
            <tr>
                <td><strong>{{ $app->full_name }}</strong></td>
                <td>{{ $app->job->title }} ({{ $app->job->type }})</td>
                <td>
                    <small>{{ $app->email }}</small><br>
                    <small>{{ $app->phone }}</small>
                </td>
                <td>
                    @if($app->resume_path)
                    <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-outline" style="padding: 2px 8px; font-size: 0.8rem;">
                        <i class="fas fa-file-pdf"></i> View CV
                    </a>
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    <span class="badge badge-{{ $app->status == 'shortlisted' ? 'confirmed' : ($app->status == 'rejected' ? 'cancelled' : 'pending') }}">
                        {{ strtoupper($app->status) }}
                    </span>
                </td>
                <td>{{ $app->created_at->format('M d, Y') }}</td>
                <td>
                    <form action="{{ route('admin.jobs.update-application-status', $app) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="form-control" style="font-size: 0.8rem; padding: 5px;">
                            <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ $app->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="shortlisted" {{ $app->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #888;">No applications received yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $applications->links() }}
    </div>
</div>
@endsection
