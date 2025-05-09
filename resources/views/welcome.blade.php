@extends('layouts.main')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div id="hero" class=" text-white text-center py-5" style="background: linear-gradient(135deg,rgb(111, 177, 231), #eef2f3);">
    <div class="container">
        <h1 class="display-6 fw-normal">Welcome to <strong>Job Seek</strong></h1>
        <h1 class="display-4 fw-bold">Find Your Dream Job Today</h1>
        <p class=" mb-4">Join thousands already discovering opportunities that match their skills.</p>
        <div>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">Get Started</a>
            <a href="{{ route('jobs.index') }}" class="btn btn-outline-light btn-lg">Browse Jobs</a>
        </div>
    </div>
</div>

<!-- Featured Jobs Section -->
<div id="featured-jobs" class=" py-5" style="background: linear-gradient(135deg,rgb(203, 173, 229),rgb(255, 255, 255));">
    <div class="container">
    <h2 class="text-center mb-4">Featured Jobs</h2>
    <div class="row">
        @forelse($featuredJobs as $job)
            <div class="col-md-4 mb-4">
                <div class="card custom-card">
                    
                    <div class="card-body">
                        <h5 class="card-title text-white">{{ $job->title }}</h5>
                        <p class="text-muted mb-2"><i class="bi bi-building me-1"></i>{{ $job->company_name }}</p>
                        <span class="badge bg-info">{{ $job->location ?? 'Remote' }}</span>
                        <p class="mt-3">
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-white btn-sm btn-info text-white">View Job</a>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col text-center">
                <p>No featured jobs available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>
</div>

<!-- About Section -->
<div id="about" class="py-5" style="background: linear-gradient(135deg,rgb(163, 184, 218),rgb(255, 255, 255));">
    <div class="container text-center">
        <h2 class="mb-4">About Job Seek</h2>
        <p class="lead mx-auto" style="max-width: 800px;">
            Job Seek is your trusted partner in finding the perfect career opportunity. Whether you're a fresh graduate or an experienced professional, we connect you with companies that value your skills and passion. With a growing network of employers and intuitive tools, your job search has never been easier.
        </p>
        <div class="mt-4">
            <a href="{{ route('register') }}" class="btn btn-primary text-white me-2">Join Us</a>
            <a href="{{ route('jobs.index') }}" class="btn btn-outline-white  btn-info text-white">View Openings</a>
        </div>
    </div>
</div>


<!-- How It Works Section -->
<div id="how-it-works" class=" py-5"style="background: linear-gradient(135deg,rgb(143, 206, 241),rgb(255, 255, 255));">
    <div class="container text-center">
        <h2 class="mb-5"> How It Works</h2>
        <div class="row" >
            <div class="col-md-4 mb-4">
                <div class="mb-3 text-primary fs-1">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h5>1. Sign Up</h5>
                <p>Create an account to get started.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="mb-3 text-success fs-1">
                    <i class="bi bi-file-earmark-person"></i>
                </div>
                <h5>2. Create Profile</h5>
                <p>Add your resume and details.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="mb-3 text-warning fs-1">
                    <i class="bi bi-send-check"></i>
                </div>
                <h5>3. Apply for Jobs</h5>
                <p>Start applying to jobs that fit you.</p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer id="footer" class="bg-lilac text-white py-4 ">
    <div class="container text-center">
        <p class="mb-1">© {{ date('Y') }} Job Seek. All rights reserved.</p>
        <small class="text-muted">Made with ❤️ for job seekers everywhere.</small>
    </div>
</footer>
@endsection
