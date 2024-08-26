@extends('layouts.admin')
@section('title', 'articles')


@section('content')

<div class="container">
    <h1>articles</h1>
    <button><a href="{{route ('writer.articles.create')}}">Create article</a></button>
    <ul>
        @foreach($articles as $article)
        <li class="list-group-item">
            <a href="{{route('writer.articles.show', $article->id) }}"> {{$article->title}}</a>
            <a href="{{route('writer.articles.edit', $article->id) }}">Edit </a>
        </li>
        @endforeach
    </ul>
</div>

@endsection