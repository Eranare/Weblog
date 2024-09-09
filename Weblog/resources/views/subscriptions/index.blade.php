@extends('layouts.app')

@section('content')
<h1>Subscribed Writers</h1>

@if($subscribedAuthors->isEmpty())
    <p>You are not subscribed to any writers yet.</p>
@else
    <ul class="list-group">
        @foreach($subscribedAuthors as $sub)
            @if($sub->active || $sub->end_date > now()) <!-- Only show active or valid subscriptions -->
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <!-- Author's name and profile link -->
                    <a href="{{ route('author.profile', $sub->author_id) }}" class="col-4">
                        {{ $sub->author->name }}
                    </a>

                    <!-- Display "Subscription ends" if canceled, otherwise "Next payment" -->
                    @if($sub->active)
                        <span class="col-4">
                            Next payment: {{ \Carbon\Carbon::parse($sub->end_date)->format('F j, Y') }}
                        </span>
                        <!-- Show the cancel button if the subscription is active -->
                        <form action="{{ route('authors.unsubscribe', $sub->author_id) }}" method="POST" class="d-inline col-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Cancel Subscription</button>
                        </form>
                    @else
                        <span class="col-4">
                            Subscription ends: {{ \Carbon\Carbon::parse($sub->end_date)->format('F j, Y') }}
                        </span>
                        <span class="badge bg-warning text-dark">Cancelled</span>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif
@endsection
