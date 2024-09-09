@extends('layouts.admin')

@section('title', 'Writer Dashboard')

@section('content')
<h1>Writer Dashboard</h1>

<div class="mb-4">
    <h2>Hello, {{ Auth::user()->name }}!</h2>
    <p>Welcome to your writer panel.</p>

    <div class="card">
        <div class="card-body">
            <h3>Statistics</h3>
            <p><strong>Followers:</strong> {{ $followersCount }}</p>
            <p><strong>Subscribers:</strong> {{ $subscribersCount }}</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>
@endsection
