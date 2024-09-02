@extends('layouts.app')

@section('content')
<h1>subbed Writers</h1>

@if($subscribedAuthors->isEmpty())
<p>You are not following any writers yet.</p>
@else
<ul>
    @foreach($subscribedAuthors as $sub)
    <li>
        <a href="{{ route('author.profile', $sub->author_id) }}" class="col-1">
            {{ $sub->SubscribedAuthor->name }}
        </a>
        <button class=col-2> unsub</button>
    </li>

    @endforeach
</ul>
@endif
@endsection