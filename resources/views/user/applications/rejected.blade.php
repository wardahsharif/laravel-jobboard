@extends('layouts.main')

@section('title', 'Rejected Applications')

@section('content')
<div class="container my-4 p-4">
    <h2 class="text-center p-5">Pending Applications</h2>

    @if($applications->count())
        <ul class="list-group">
            @foreach($applications as $application)
                <li class="list-group-item">
                    {{ $application->job->title ?? 'Job not found' }} — Submitted on {{ $application->created_at->format('M d, Y') }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No rejected applications.</p>
    @endif
</div>
@endsection
