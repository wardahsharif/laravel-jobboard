@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-4">
    <div class="container">
        <div class="card shadow-sm p-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Welcome Admin') }}
            </h2>
        </div>
    </div>
</div>
@endsection
