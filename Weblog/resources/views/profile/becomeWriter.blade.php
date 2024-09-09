<!-- resources/views/profile/becomeWriter.blade.php -->

@extends('layouts.app')

@section('title', 'Become a Writer')

@section('content')
<div class="container">
    <h1>Become a Writer</h1>

    <p>To become a writer on our platform, you must agree to our terms of service:</p>

    <h4>Terms of Service</h4>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt, nisl eget gravida accumsan, mi libero
        tempus est, non consectetur odio erat non velit. Vivamus at leo vitae velit volutpat consequat.
    </p>

    <!-- Form to confirm becoming a writer -->
    <form action="{{ route('profile.confirmBecomeWriter') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">I Agree and Confirm</button>
    </form>
</div>
@endsection
