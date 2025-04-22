@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Edit Profile Card -->
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-profile text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                    <small class="text-light">Update your account information below.</small>
                </div>

                <div class="card-body">
                    @include('profile.update-profile-information-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
