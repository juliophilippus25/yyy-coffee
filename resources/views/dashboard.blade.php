@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
            <p class="mb-0">Welcome, {{ Auth::user()->name }}!</p>
        </div>
    </div>
@endsection
