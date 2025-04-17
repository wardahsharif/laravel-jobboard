@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Admin Dashboard</h2>

    <div class="row mt-4">
        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-users"></i> All Users
                </h5>
                <p class="card-text">{{ $totalUsers }} Users</p>
                <a href="{{ route('admin.all-users') }}" class="btn btn-info">View Users</a>
            </div>
        </div>

        <!-- Total Jobs -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-briefcase"></i> Total Jobs
                </h5>
                <p class="card-text">{{ $totalJobs }} Jobs</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary">View Jobs</a>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-file"></i> Total Applications
                </h5>
                <p class="card-text">{{ $totalApplications }} Applications</p>
                <a href="{{ route('admin.applications.all') }}" class="btn btn-secondary">View Applications</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Pending Applications -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-hourglass-half"></i> Pending Applications
                </h5>
                <p class="card-text">{{ $pendingApplications }} Applications</p>
                <a href="{{ route('admin.applications.pending') }}" class="btn btn-warning">View Pending Applications</a>
            </div>
        </div>

        <!-- Approved Applications -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-check-circle"></i> Approved Applications
                </h5>
                <p class="card-text">{{ $approvedApplications }} Applications</p>
                <a href="{{ route('admin.applications.approved') }}" class="btn btn-success">View Approved Applications</a>
            </div>
        </div>

        <!-- Rejected Applications -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-times-circle"></i> Rejected Applications
                </h5>
                <p class="card-text">{{ $rejectedApplications }} Applications</p>
                <a href="{{ route('admin.applications.rejected') }}" class="btn btn-danger">View Rejected Applications</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Total Employers -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-briefcase"></i> Total Employers
                </h5>
                <p class="card-text">{{ $totalEmployers }} Employers</p>
                <a href="{{ route('admin.employer.index') }}" class="btn btn-primary">View Employers</a>
            </div>
        </div>

        <!-- Regular Users -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">
                    <i class="fa fa-users"></i> Regular Users
                </h5>
                <p class="card-text">{{ $totalRegularUsers }} Users</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-info">View Users</a>
            </div>
        </div>
    </div>
</div>
@endsection
