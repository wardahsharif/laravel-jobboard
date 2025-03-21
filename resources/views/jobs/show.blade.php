@extends('layouts.main')

@section('title', $job->title)

@section('content')
    <div class="container">
        <h2>{{ $job->title }}</h2>
        <p><strong>Company:</strong> {{ $job->company }}</p>
        <p><strong>Location:</strong> {{ $job->location }}</p>
        <p><strong>Salary:</strong> {{ $job->salary ? '$' . number_format($job->salary, 2) : 'Not specified' }}</p>
        <p><strong>Job Type:</strong> {{ $job->type }}</p>
        <p><strong>Description:</strong> {{ $job->description }}</p>

        @if(auth()->id() === $job->user_id)
            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endif

        <a href="{{ route('application.create', $job->id) }}" class="btn btn-primary">
            Apply for this Job
        </a>
        
        <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">Back to Listings</a>
    </div>
@endsection
