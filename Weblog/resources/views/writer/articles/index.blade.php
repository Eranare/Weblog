@extends('layouts.admin')
@section('title', 'Articles')

@section('content')
<div class="container">
    <h1>Your Articles</h1>
    <button><a href="{{route('writer.articles.create')}}">Create Article</a></button>
    <ul class="list-group">
        @foreach($articles as $article)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <a href="{{route('writer.articles.show', $article->id)}}"> {{$article->title}}</a>
                <a href="{{route('writer.articles.edit', $article->id)}}">Edit</a>
            </div>
            <div>
                <form action="{{ route($article->is_flagged_for_deletion ? 'writer.articles.unhide' : 'writer.articles.hide', $article->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="checkbox" name="is_hidden" {{ $article->is_flagged_for_deletion ? 'checked' : '' }} onchange="this.form.submit()">
                    <label for="is_hidden">{{ $article->is_flagged_for_deletion ? 'Unhide' : 'Hide' }}</label>
                </form>

                <form action="{{ route('writer.articles.destroy', $article->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" {{ $article->is_flagged_for_deletion ? '' : 'disabled' }}>Delete</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection