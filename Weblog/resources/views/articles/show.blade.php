@extends('layouts.app')
@section('title', $article->title)

@section('content')
    <h2>{{ $article->title }}</h2>
    <h4>
        by {{ $author->name }}
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
        @endif
    </h4>

    <div class="article-content mb-4">
        {!! $htmlContent !!}
    </div>

    @include('comments.show')
@endsection
