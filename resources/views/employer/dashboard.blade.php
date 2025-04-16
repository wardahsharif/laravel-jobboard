@extends('layouts.main')

@section('title', 'Employer Dashboard')

@section('content')
<div class="py-4">
    <div class="container">
        <div class="card shadow-sm p-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Welcome Employer') }}
            </h2>
        </div>

        <div class="row mt-4">
            <!-- Active Jobs -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Active Jobs</h5>
                   <p class="card-text">{{ $activeJobs }} Jobs</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">View Active Jobs</a>
                </div>
            </div>

            <!-- Closed Jobs -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Closed Jobs</h5>
                    <p class="card-text">{{ $closedJobs }} Jobs</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">View Closed Jobs</a>
                </div>
            </div>

              <!-- Pending Applications -->
              <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Pending Applications</h5>
                    <p class="card-text">{{ $pendingApplications->count() }} Applications</p>
                    <a href="{{ route('application.pending') }}" class="btn btn-info">View Pending Applications</a>
                </div>
            </div>
        </div>

          <!-- approved Applications -->
          <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Approved Applications</h5>
                    <p class="card-text">{{ $approvedApplications->count() }} Applications</p>
                    <a href="{{ route('application.approved') }}" class="btn btn-info">View Pending Applications</a>
                </div>
            </div>
        </div>



     
    </div>
</div>
@endsection
