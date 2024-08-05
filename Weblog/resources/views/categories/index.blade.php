@extends('layouts.app')
@section('title', 'Categories')


@section('content')

<div class="container">
    <h1>Categories</h1>

    @if (session('succes'))
    <div class="alert alert-succes">
        {{session('succes')}}
    </div>
    @endif
    <ul>
        @foreach($categories as $category)
        <li class="list-group-item">
            <a href="{{route('categories.show', $category->id) }}"> {{$category->name}}</a>
        </li>
        @endforeach
    </ul>
</div>

@endsection