@extends('layouts.admin')
@section('title', 'create article')


@section('content')
<div class="container">
    <h1>Create new article</h1>

    @if(session('succes'))
    <div class="alert alert-succes">
        {{session('succes')}}
    </div>
    @endif

    <form action="{{route ('writer.articles.store') }}" method="POST">
        @csrf
        Premium article: <input type="checkbox" name="is_premium" id="is_premium">
        <div class='form-group'>
            <label for="Title">Title*</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        Temporary image upload, not working yet
        <div class="form-group">
            <label for="content">Content*</label>
            <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
        </div>
        <!--  TEMP CATEGORIES  -->
        <div class="modal-body">
            <ul>
                @foreach($categories as $category)
                <li>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}
                </li>
                @endforeach
            </ul>
        </div>
        <!--  TEMP CATEGORIES  -->

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoriesModal">
            Category tags
        </button>
        <li>
            This button is meant to show a scrollable modal box that holds all current existing categories and the option to create new ones.
            select categories here
        </li>
        <br>
        <button type="submit">SEND IT</button>

    </form>

</div>



<!-- Categories Modal -->
<div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalLabel">Select Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach($categories as $category)
                    <li>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection