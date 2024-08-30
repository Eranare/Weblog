@extends('layouts.app')
@section('title', '')

@section('content')
<div class="container">
    <h1>Latest Articles</h1>
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-6">
            <div class="card mb-4">
            <img src="https://cataas.com/cat?{{ Str::random(10) }}" class="card-img-top" alt="Article Image">
                <div class="card-body">
                    <h4><a href="{{ route('articles.show', $article->id)}}"> {{$article->title}} </a></h4>
                    
                    <h5>By </h5><h4>AuthorName </h4>
                    <p>{{Str::limit(strip_tags($article->content), 150)}} </p> <!--Render preview text with ajax maybe? expensive tho. maybe save preview text when saving the article. like the first paragraph? -->
                </div>      
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{$articles->links()}} hi
    </div>
</div>
@endsection