<!-- resources/views/premium/subscribe.blade.php -->
@extends('layouts.app')

@section('title', 'Subscribe to Premium')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Become a Premium Member</h1>
    <p>Unlock exclusive content, enjoy ad-free reading, and more by becoming a premium member.</p>
    <form action="{{ route('premium.processSubscription') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Subscribe Now</button>
    </form>
</div>
@endsection
