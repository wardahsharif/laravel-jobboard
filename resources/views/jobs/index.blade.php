@extends('layouts.main')

@section('title', 'Job Listings')

@section('content')
    <div class="container pt-5 ">
        <h2 class="text-center">Job Listings</h2>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">Post a Job</a>

        <ul class="list-group mt-3">
            @foreach ($jobs as $job)
                <li class="list-group-item">
                    <a href="{{ route('jobs.show', $job->id) }}" class="fw-bold">{{ $job->title }}</a> 
                    <br>
                    <small>{{ $job->company }} - {{ $job->location }}</small>
                </li>
            @endforeach
        </ul>

        <div  class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    </div>
@endsection
