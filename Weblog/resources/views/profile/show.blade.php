<!-- resources/views/profile/show.blade.php -->

@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
<div class="container">
    <h1>Your Profile</h1>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-outline-primary mt-3">Update Profile</button>
    </form>

    <!-- Show "Start Earning" button only if the user is not a writer -->
    @if(!$user->is_writer)
    <br>
    <a href="{{ route('profile.becomeWriter') }}" class="btn btn-info btn-lg mt-3">
        Start Earning<br>Become a Creator
    </a>
    @endif
</div>
@endsection
