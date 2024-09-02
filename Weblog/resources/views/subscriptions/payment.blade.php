@extends('layouts.app')

@section('title', 'Subscribe to ' . $author->name)

@section('content')
<div class="container">
    <h2>Subscribe to {{ $author->name }}</h2>
    <p>To access premium content from this author, please complete the subscription process.</p>

    <!-- Display subscription options -->
    <form action="{{ route('authors.subscribe', $author->id) }}" method="POST">
        @csrf

        <!-- You can add more details about the subscription, like duration, price, etc. -->
        <div class="mb-3">
            <label for="subscriptionPlan" class="form-label">Choose a Plan</label>
            <select class="form-select" id="subscriptionPlan" name="plan" required>
                <option value="monthly">Monthly - $5.00</option>
                <option value="yearly">Yearly - $50.00</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Subscribe and Pay</button>
    </form>
</div>
@endsection
