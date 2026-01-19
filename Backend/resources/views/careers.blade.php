@extends('layouts.app')

@section('content')
<style>
    .careers-hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1556742526-905206927357?q=80&w=2000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        padding: 20px;
    }
    .careers-hero h1 { font-size: 3.5rem; margin-bottom: 15px; }
    .careers-hero p { font-size: 1.2rem; max-width: 700px; }

    .career-section { padding: 80px 10%; }
    .section-header { text-align: center; margin-bottom: 50px; }
    .section-header h2 { font-size: 2.5rem; color: #333; }
    .section-header p { color: #888; margin-top: 10px; }

    .job-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }
    .job-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
    }
    .job-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(212, 165, 110, 0.15); border-color: #d4a56e; }
    .job-type {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    .type-vacancy { background: #fff1e0; color: #d4a56e; }
    .type-internship { background: #e0f2ff; color: #3498db; }
    
    .job-title { font-size: 1.5rem; margin-bottom: 10px; color: #333; }
    .job-meta { display: flex; gap: 15px; color: #888; font-size: 0.9rem; margin-bottom: 20px; }
    .job-meta i { margin-right: 5px; color: #d4a56e; }

    .job-desc { color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px; flex-grow: 1; }
    
    .apply-btn {
        background: #d4a56e;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }
    .apply-btn:hover { background: #c0915a; }

    .empty-state {
        text-align: center;
        padding: 50px;
        background: #f9f9f9;
        border-radius: 20px;
        color: #888;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
    }
    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 40px;
        border-radius: 25px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    }
    .close { float: right; font-size: 28px; font-weight: bold; cursor: pointer; color: #aaa; }
    .close:hover { color: #333; }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-family: inherit;
    }
</style>

<div class="careers-hero">
    <h1>Join Our Sweet Team</h1>
    <p>We are always looking for passionate individuals who love baking and making people happy. Start your journey with Cinnamon Bakery today.</p>
</div>

<div class="career-section">
    <div class="section-header">
        <h2>Open Vacancies</h2>
        <p>Current full-time and part-time opportunities</p>
    </div>

    @if($vacancies->isEmpty())
        <div class="empty-state">
            <p>No active vacancies at the moment. Check back later!</p>
        </div>
    @else
        <div class="job-grid">
            @foreach($vacancies as $job)
            <div class="job-card">
                <span class="job-type type-vacancy">Vacancy</span>
                <h3 class="job-title">{{ $job->title }}</h3>
                <div class="job-meta">
                    <span><i class="fas fa-building"></i> {{ $job->department }}</span>
                    <span><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</span>
                </div>
                <p class="job-desc">{{ Str::limit($job->description, 150) }}</p>
                <button class="apply-btn" onclick="openApplyModal({{ $job->id }}, '{{ $job->title }}')">Apply Now</button>
            </div>
            @endforeach
        </div>
    @endif

    <div class="section-header" style="margin-top: 100px;">
        <h2>Internship Opportunities</h2>
        <p>Learn from the best and grow your skills</p>
    </div>

    @if($internships->isEmpty())
        <div class="empty-state">
            <p>No internship openings currently. We'll announce new cohorts soon!</p>
        </div>
    @else
        <div class="job-grid">
            @foreach($internships as $job)
            <div class="job-card">
                <span class="job-type type-internship">Internship</span>
                <h3 class="job-title">{{ $job->title }}</h3>
                <div class="job-meta">
                    <span><i class="fas fa-building"></i> {{ $job->department }}</span>
                    <span><i class="fas fa-clock"></i> {{ $job->duration ?? '3 Months' }}</span>
                </div>
                <p class="job-desc">{{ Str::limit($job->description, 150) }}</p>
                <button class="apply-btn" onclick="openApplyModal({{ $job->id }}, '{{ $job->title }}')">Apply Now</button>
            </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Application Modal -->
<div id="applyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalJobTitle" style="margin-bottom: 5px;">Apply for Role</h2>
        <p style="color: #888; margin-bottom: 25px;">Please fill out the form below to submit your application.</p>
        
        <form id="applyForm" action="{{ route('jobs.apply') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="job_id" id="job_id_input">
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required placeholder="John Doe">
            </div>
            
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required placeholder="98XXXXXXXX">
                </div>
            </div>
            
            <div class="form-group">
                <label>Resume / CV (PDF or Word)</label>
                <input type="file" name="resume" required accept=".pdf,.doc,.docx">
            </div>
            
            <div class="form-group">
                <label>Short Message / Cover Letter</label>
                <textarea name="message" rows="4" placeholder="Tell us why you're a great fit..."></textarea>
            </div>
            
            <button type="submit" class="apply-btn" style="width: 100%; font-size: 1.1rem; padding: 15px;">Submit Application</button>
        </form>
    </div>
</div>

<script>
    function openApplyModal(jobId, jobTitle) {
        document.getElementById('job_id_input').value = jobId;
        document.getElementById('modalJobTitle').innerText = 'Apply for ' + jobTitle;
        document.getElementById('applyModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('applyModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('applyModal')) {
            closeModal();
        }
    }
</script>
@endsection
