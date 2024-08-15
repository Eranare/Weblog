@extends('layouts.app')
@section('title', $category->name)


@section('content')

<?php 

/* We should send the articles linked to this category here and display them.
*/?>
<h2>{{$category->name}}</h2>

<ul>
        @foreach($articles as $article)
        <li class="list-group-item">
            <a href="{{route('articles.show', $article->id) }}"> hi {{$article->name}}</a>
            {{$article->preview}}
           
        </li>
        @endforeach
    </ul>

    @endsection