@extends('layouts.app')
@section('title', 'Home')

@section('content')
<div class="container">
    <h1>Latest Articles</h1>
    <div class="row">
        @foreach($paginatedArticles as $article)
        <div class="col-md-6">
            <div class="card mb-4 h-100 position-relative">
                <img src="https://cataas.com/cat?{{ Str::random(10) }}" class="card-img-top fixed-image" alt="Article Image">
                <div class="card-body d-flex flex-column">
                    <h4><a href="{{ route('articles.show', $article->id)}}"> {{$article->title}} </a></h4>
                    <h5>By</h5><h4>{{ $article->user->name }}</h4>
                    <p class="card-text">{{ Str::limit(strip_tags($article->content), 150) }} </p>
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
    <div class="d-flex justify-content-center">
        {{ $paginatedArticles->links() }}
    </div>
</div>
@endsection