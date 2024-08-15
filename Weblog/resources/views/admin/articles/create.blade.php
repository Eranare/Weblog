@extends('layouts.admin')
@section('title', 'Create Article')

@section('content')
<div class="container">
    <h1>Create a New Article</h1>
    
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="10"></textarea>
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
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriesModal">
            Category tags
        </button>
        <li>
            This button is meant to show a scrollable modal box that holds all current existing categories and the option to create new ones. 
            select categories here
        </li>
        <br>
        

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
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
<script>
    const uploadUrl = "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@vite('resources/js/app.js')
@endsection
