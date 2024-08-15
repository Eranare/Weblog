@extends('layouts.admin')
@section('title', 'create category')


@section('content')
<div class="container">
    <h1>Create new article</h1>

    @if(session('succes'))
    <div class="alert alert-succes">
        {{session('succes')}}
    </div>
    @endif

    <form action="{{route ('admin.categories.store') }}" method="POST">
        @csrf

        <div class='form-group'>
            <label for="Title">Name*</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="">
            <h3>Existing categories</h3>
            <ul>
                @foreach($categories as $category)
                <li style="list-style-type: none">
                    <p name="categories[]" value="{{ $category->id }}"> {{ $category->name }} </p>
                </li>
                @endforeach
            </ul>
        </div>

        <br>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>

    </form>

</div>




@endsection