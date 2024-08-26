@extends('layouts.admin')
@section('title', $category->name)

@section('content')

<h2>{{$category->name}}</h2>

<ul>
    @foreach($articles as $article)
    <li class="list-group-item">
        <a href="{{route('writer.articles.show', $article->id) }}"> {{$article->title}}</a>
        {{$article->preview}}

    </li>
    @endforeach
</ul>

@endsection