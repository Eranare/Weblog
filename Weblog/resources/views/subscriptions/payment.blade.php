@extends('layouts.app')

@section('title', 'Subscribe to ' . $author->name)

@section('content')
<h2>Subscribe to {{ $author->name }}</h2>

<p>Select your subscription plan:</p>

<form action="{{ route('authors.subscribe', $author->id) }}" method="POST">
    @csrf
    <!-- Send back the redirect URL -->
    <input type="hidden" name="redirect_url" value="{{ request('redirect_url') }}">
    
    <div class="form-group">
        <label>
            <input type="radio" name="plan" value="monthly" checked>
            Monthly Subscription ($10/month)
        </label>
    </div>

    <div class="form-group">
        <label>
            <input type="radio" name="plan" value="yearly">
            Yearly Subscription ($100/year)
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Confirm Subscription</button>
</form>
@endsection
