@extends('layouts.app')
@section('title', 'Home')

@section('content')
<div class="container">
    <h1>Latest Articles</h1>
    <div class="row">
        @foreach($paginatedArticles as $article)
        <div class="col-md-6">
            <div class="card mb-4 h-100 position-relative" style="min-height: 400px;">
                @if ($article->banner_image_path != "")
                <img src="{{$article->banner_image_path}}" class="card-img-top fixed-image" alt="{{$article->title}}" style="height: 15vh; object-fit: cover; width: 100%;">
                @else
                <!-- Placeholder for articles with no image -->
                <div class="card-img-top fixed-image d-flex align-items-center justify-content-center" style="height: 15vh; background-image: linear-gradient(to right, #74ebd5, #ACB6E5);">
                    <span class="text-white">{{$article->title}}</span>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h4><a href="{{ route('articles.show', $article->id)}}"> {{$article->title}} </a></h4>
                    <h5>By</h5>
                    <h4><a href="{{ route('author.profile', $article->user) }}"> {{ $article->user->name }}</a></h4>
                    
                    <!-- Show content preview -->
                    <p class="card-text">{{ Str::limit($article->content_preview, 150) }} </p>

                    <!-- Category Tags -->
                    <div class="mt-2">
                        @foreach($article->categories->take(3) as $category)
                        <a href="{{ route('categories.show', $category->id) }}" class="badge bg-secondary text-decoration-none">{{ $category->name }}</a>
                        @endforeach
                    </div>

                    <p class="card-text">Published: {{$article->created_at->format('Y-m-d H:i:s')}}</p>
                    
                    <!-- Spacer for card alignment -->
                    <div class="mt-auto"></div>

                    <!-- "Read More" button -->
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">Read More</a>
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
    
    <!-- Pagination controls -->
    <div class="d-flex justify-content-center">
        {{ $paginatedArticles->links() }}
    </div>
</div>
@endsection
