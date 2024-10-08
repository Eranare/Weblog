@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-6">
            <div class="card mb-4 h-100 position-relative">
                @if ($article->banner_image_path != "")
                <img src="{{ asset($article->banner_image_path) }}" class="card-img-top fixed-image" alt="{{ $article->title }}">
                @else
                <!-- Placeholder for articles with no image -->
                <div class="card-img-top fixed-image d-flex align-items-center justify-content-center" style="height: 15vh; background-color: #f0f0f0;">
                    <span class="text-muted">No Image Available</span>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h4><a href="{{ route('articles.show', $article->id) }}"> {{ $article->title }} </a></h4>
                    <h5>By</h5>
                    <h4><a href="{{ route('author.profile', $article->user) }}"> {{ $article->user->name }}</a></h4>
                    <p class="card-text">{{ $article->content_preview }} </p>
                    <p class="card-text"> Published: {{ $article->created_at->format('Y-m-d H:i:s') }} </p>
                    <a href="{{ route('articles.show', $article->id) }}" class="mt-auto btn btn-primary">Read More</a>
                </div>
                @if($article->is_premium)
                <div class="badge bg-warning text-dark position-absolute" style="bottom: 10px; left: 10px;">
                    Premium
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection
