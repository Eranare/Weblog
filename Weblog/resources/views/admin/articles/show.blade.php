@extends('layouts.admin')
@section('title', $article->name)


@section('content')
    <h2>{{ $article->name }}</h2>

    <div class="article-content">
        {!! $htmlContent !!}
    </div>
    @endsection