<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Vacancy,Internship',
            'department' => 'required|string',
            'description' => 'required',
            'deadline' => 'nullable|date',
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Job posted successfully.');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Vacancy,Internship',
            'department' => 'required|string',
            'description' => 'required',
        ]);

        $job->update($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function applications()
    {
        $applications = JobApplication::with('job')->latest()->paginate(15);
        return view('admin.jobs.applications', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $request->validate(['status' => 'required|in:pending,reviewed,shortlisted,rejected']);
        $application->update(['status' => $request->status]);
        return back()->with('success', 'Application status updated.');
    }
}
