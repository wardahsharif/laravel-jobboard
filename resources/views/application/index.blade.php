@extends('layouts.main')

@section('title', 'My Applications')

@section('content')
    <div class="container mt-4">
        <h1>My Job Applications</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <ul class="list-group">
            @foreach ($applications as $application)
                <li class="list-group-item">
                    <strong>{{ $application->job->title }}</strong> at {{ $application->job->company }}
                    <span class="text-muted">Applied on {{ $application->created_at->format('d M Y') }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
