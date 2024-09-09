@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <h1>{{ $author->name }}</h1>

    <!-- Follow and Subscribe buttons -->
    @if(Auth::check() && Auth::id() !== $author->id)
        <!-- Follow/Unfollow Button -->
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

        <!-- Subscribe/Unsubscribe Button -->
        @if($isSubscribed)
        <span class="badge bg-success ms-2">Subscribed</span>
        @else
        <form action="{{ route('authors.subscribe.show', $author->id) }}" method="GET" class="d-inline">
        @csrf
        <!-- Add the redirect URL -->
        <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
        <button type="submit" class="btn btn-warning btn-sm">Subscribe</button>
    </form>
        @endif
    @endif

    <!-- Display author's bio -->
    @if ($author->profile && $author->profile->bio)
        <p>{{ Str::limit($author->profile->bio, 100) }}</p>
        @if (strlen($author->profile->bio) > 100)
            <button class="btn btn-link" id="show-more-btn">Show More</button>
            <p id="full-bio" style="display:none;">{{ $author->profile->bio }}</p>
        @endif
    @endif

    <!-- Display author's Twitter handle -->
    @if ($author->profile && $author->profile->twitter_handle)
        <p>
            <a href="https://twitter.com/{{ $author->profile->twitter_handle }}" target="_blank">
                <i class="fab fa-twitter"></i> Follow on Twitter
            </a>
        </p>
    @endif

    <!-- Paginated list of articles by the author -->
    <h2>Articles by {{ $author->name }}</h2>

    @if ($articles->isEmpty())
        <p>This author has not written any articles yet.</p>
    @else
        <div class="row">
            @foreach ($articles as $article)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="{{ $article->banner_image_path }}" class="card-img-top" alt="Article Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">
                                {{ Str::limit(strip_tags($article->content), 100) }} <!-- Short preview -->
                            </p>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    @endif
@endsection
