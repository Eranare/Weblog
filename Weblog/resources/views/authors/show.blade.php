@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <h1>{{ $author->name }}</h1>
    <p>Articles by {{ $author->name }}:</p>

    @if($articles->isEmpty())
        <p>This author has not written any articles yet.</p>
    @else
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="https://cataas.com/cat?{{ Str::random(10) }}" class="card-img-top" alt="Cat Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">
                                {{ Str::limit(strip_tags($article->content), 100) }} <!-- A short preview of the content -->
                            </p>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
