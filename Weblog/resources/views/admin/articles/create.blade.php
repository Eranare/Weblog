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

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
<script>
    const uploadUrl = "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}";
</script>
@vite('resources/js/app.js')
@endsection
