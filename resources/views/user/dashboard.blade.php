@extends('layouts.main')

@section('title', 'User Dashboard')

@section('content')
<div class="py-4">
    <div class="container">
        <div class="card shadow-sm p-4 mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('Welcome ' .$user->username) }} !💌
            </h2>
        </div>

        <div class="container p-4">
            <div class="row">
                <!-- Total Applications -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-3 h-100">
                        <h5 class="card-title">Total Applications</h5>
                        <p class="card-text">{{ $totalApplications }} Applications</p>
                        <a href="{{ route('application.index') }}" class="btn btn-primary">View My Applications</a>
                    </div>
                </div>

                <!-- Pending Applications -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-3 h-100">
                        <h5 class="card-title">Pending Applications</h5>
                        <p class="card-text">{{ $pendingApplications }} Applications</p>
                        <a href="{{ route('user.applications.pending') }}" class="btn btn-info">View Pending</a>
                    </div>
                </div>

                <!-- Approved Applications -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-3 h-100">
                        <h5 class="card-title">Approved Applications</h5>
                        <p class="card-text">{{ $approvedApplications }} Applications</p>
                        <a href="{{ route('user.applications.approved') }}" class="btn btn-success">View Approved</a>
                    </div>
                </div>

                <!-- Rejected Applications -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-3 h-100">
                        <h5 class="card-title">Rejected Applications</h5>
                        <p class="card-text">{{ $rejectedApplications }} Applications</p>
                        <a href="{{ route('user.applications.rejected') }}" class="btn btn-danger">View Rejected</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
