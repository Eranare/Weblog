@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1></h1>
    <div class = "">
    
    Hello, welcome to the admin panel.
    </div>
<form method="POST" action="{{route ('logout')}}">
@csrf
    <button action="submit">logout</button>
</form>

@endsection