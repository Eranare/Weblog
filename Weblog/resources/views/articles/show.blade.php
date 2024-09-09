@extends('layouts.app')
@section('title', $article->title)

@section('content')
<h2>{{ $article->title }}</h2>
<h4>
    by <a href="{{ route('author.profile', $article->user) }}">{{ $author->name }}</a>
    @if(Auth::check())
    @if(Auth::user()->isFollowing($author->id))
    <form action="{{ route('authors.unfollow', $author->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm ms-2">Unfollow</button>
    </form>
    @else
    <form action="{{ route('authors.follow', $author->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-primary btn-sm ms-2">Follow</button>
    </form>
    @endif

    @if($isSubscribed)
    <span class="badge bg-success ms-2">Subscribed</span>
    @else
    <form action="{{ route('authors.subscribe.show', $author->id) }}" method="GET" class="d-inline">
        @csrf
        <!-- Add the redirect URL -->
        <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
        <button type="submit" class="btn btn-warning btn-sm ms-2">Subscribe</button>
    </form>
    @endif
    @endif
</h4>

<div class="article-content mb-4">
    @if($article->is_premium && !$isSubscribed)
    {!! Str::words(strip_tags($htmlContent), 150, '...') !!}
    <div class="paywall">
        <p>To read the full article, please subscribe to this author.</p>
        <a href="{{ route('authors.subscribe.show', $author->id) }}" class="btn btn-warning">Subscribe Now</a>
    </div>
    @else
    {!! $htmlContent !!}
    @include('comments.show')
    @endif
</div>
@endsection