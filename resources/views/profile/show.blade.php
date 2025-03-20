@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Profile Information -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
                <p class="mt-1 text-sm text-gray-600">{{ __("Here is your account information.") }}</p>

                <div class="mt-4">
                    <p><strong>Name:</strong> {{ auth()->user()->username ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                </div>

                <!-- Edit Profile Button -->
                <div class="mt-4 ">
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-blue-500 text-light bg-dark border rounded text-decoration-none">
                        Edit Profile
                    </a>
                    
                </div>
            </div>
        </div>

       
        
@endsection
