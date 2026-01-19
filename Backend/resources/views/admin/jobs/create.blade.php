@extends('admin.layout')

@section('title', 'Post New Role')
@section('header', 'Post New Career Opportunity')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Senior Pastry Chef" required>
            </div>
            
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="Vacancy">Vacancy</option>
                    <option value="Internship">Internship</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Department</label>
                <input type="text" name="department" class="form-control" placeholder="e.g. Kitchen, Delivery, Marketing" required>
            </div>
            
            <div class="form-group">
                <label>Deadline</label>
                <input type="date" name="deadline" class="form-control">
            </div>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Detailed job description..." required></textarea>
        </div>

        <div class="form-group">
            <label>Requirements</label>
            <textarea name="requirements" class="form-control" rows="5" placeholder="Key qualifications, skills..."></textarea>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">Post Opportunity</button>
            <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline" style="padding: 12px 30px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
