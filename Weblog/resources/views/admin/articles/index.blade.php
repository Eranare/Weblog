@extends('layouts.admin')
@section('title', 'articles')


@section('content')

<div class="container">
    <h1>articles</h1>
    <button><a href="{{route ('admin.articles.create')}}">Create article</a></button>
    <ul>
        @foreach($articles as $article)
        <li class="list-group-item">
            <a href="{{route('admin.articles.show', $article->id) }}"> {{$article->title}}</a>
        </li>
        @endforeach
    </ul>
</div>

@endsection