@extends('layouts.app')

@section('content')
    <h1>Followed Writers</h1>

    @if($followedAuthors->isEmpty())
        <p>You are not following any writers yet.</p>
    @else
        <ul>
            @foreach($followedAuthors as $follow)
                <li>
                    <a href="{{ route('author.profile', $follow->followed_id) }}">
                        {{ $follow->followedUser->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
