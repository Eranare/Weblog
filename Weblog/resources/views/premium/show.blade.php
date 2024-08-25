<!-- resources/views/premium/show.blade.php -->
@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">{{ $article->title }}</h1>

    @if(auth()->check() && auth()->user()->is_premium)
        <!-- Show full article content for premium users -->
        <div class="article-content">
            {!! $article->content !!}
        </div>
    @else
        <!-- Show only a teaser for non-premium users -->
        <div class="article-content">
            <p>{{ Str::limit(strip_tags($article->content), 200) }}</p>
            <a href="{{ route('premium.subscribe') }}" class="btn btn-primary">Subscribe to Unlock Full Article</a>
        </div>
    @endif
</div>
@endsection
