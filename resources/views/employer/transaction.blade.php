@extends('layouts.main')

@section('title', 'My Transactions')

@section('content')
<div class="container py-5 text-center">
    <h2>My Transactions</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Amount (KES)</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->reference }}</td>
                    <td>{{ $transaction->amount / 100 }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No transactions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
