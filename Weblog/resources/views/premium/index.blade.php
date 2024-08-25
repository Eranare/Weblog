<!-- resources/views/premium/index.blade.php -->
@extends('layouts.app')

@section('title', 'Premium Articles')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Premium Articles</h1>

    @if($premiumArticles->count())
        <div class="row">
            @foreach($premiumArticles as $article)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $article->image_url }}" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <!-- Show the preview content for everyone -->
                            <p class="card-text">
                                {{ Str::limit($article->excerpt, 100) }}
                            </p>
                            @if(auth()->check() && auth()->user()->is_premium)
                                <!-- Full access link for premium users -->
                                <a href="{{ route('premium.show', $article->id) }}" class="btn btn-primary">Read Full Article</a>
                            @else
                                <!-- Teaser link for non-premium users -->
                                <a href="{{ route('premium.show', $article->id) }}" class="btn btn-secondary">Preview Article</a>
                                <small class="d-block text-muted">Subscribe to unlock full content</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $premiumArticles->links() }}
        </div>
    @else
        <p>No premium articles available at the moment.</p>
    @endif
</div>
@endsection
