@extends('layouts.main')

@section('title', 'Confirm Job Details')

@section('content')
<div class="container p-5 my-5 border rounded">
    <h2 class="mb-3">Confirm Job Details</h2>

    <form action="{{ route('payments.process') }}" method="POST">
        @csrf
        @foreach($job as $key => $value)
            @if($key !== '_token')
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
            @endif
        @endforeach

        <!-- Amount Field -->
        <input type="hidden" name="amount" value="500">

        <!-- Disclaimer  -->
        <div class="alert alert-info mt-3">
            <strong>Notice:</strong> To post a job, a payment of 500 KES is required. Please proceed to the payment step to confirm your job listing.
        </div>

        
        <button type="submit" class="btn btn-primary mt-3">Proceed to Payment</button>
    </form>

    
    <a href="{{ route('jobs.create') }}" class="btn btn-list mt-3">Back to Job Creation</a>
</div>
@endsection
