<!--Obsolete -->

@extends('layouts.app')
@section('title', 'articles')


@section('content')

<div class="container">
    <ul>
        @foreach($articles as $article)
        <li class="list-group-item">
            <a href="{{route('articles.show', $article->id) }}"> {{$article->title}}</a>
        </li>
        @endforeach
    </ul>
</div>

@endsection