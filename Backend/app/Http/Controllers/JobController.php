<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $vacancies = Job::where('type', 'Vacancy')->where('is_active', true)->get();
        $internships = Job::where('type', 'Internship')->where('is_active', true)->get();
        return view('careers', compact('vacancies', 'internships'));
    }

    public function apply(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('resume')->store('resumes', 'public');

        JobApplication::create([
            'job_id' => $request->job_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'resume_path' => $path,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your application has been submitted successfully.');
    }
}
