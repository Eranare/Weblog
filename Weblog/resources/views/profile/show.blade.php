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
        <div class="form-group form-check">
            <input type="checkbox" id="is_writer" name="is_writer" class="form-check-input" {{ $user->is_writer ? 'checked' : '' }}>
            <label for="is_writer" class="form-check-label">Become a Writer</label>
        </div>



        <button type="submit" class="btn btn-outline-primary mt-3">Update Profile</button>
    </form>
    <br>
    <button class="btn btn-info btn-lg mt-3 ">Start Earning<br>Become a Creator <a href=""></a></button>
</div>
@endsection