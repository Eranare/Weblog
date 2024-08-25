

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

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriesModal">
            Category tags
        </button>
        <p>This button opens a scrollable modal box that shows all current existing categories and the option to create new ones.</p>
        
        <!-- Categories selected display -->
        <div id="selectedCategories" class="mt-3">
            <strong>Selected Categories:</strong>
            <ul id="selectedCategoriesList">
                <!-- Selected categories will be listed here dynamically -->
            </ul>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>

<!-- Categories Modal -->
<div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalLabel">Select Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach($categories as $category)
                    <li>
                        <input type="checkbox" class="category-checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCategoriesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveCategoriesBtn = document.getElementById('saveCategoriesBtn');
        const selectedCategoriesList = document.getElementById('selectedCategoriesList');
        const checkboxes = document.querySelectorAll('.category-checkbox');

        saveCategoriesBtn.addEventListener('click', function () {
            // Clear the selected categories list
            selectedCategoriesList.innerHTML = '';

            // Iterate over checkboxes to add selected categories to the list
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    const listItem = document.createElement('li');
                    listItem.textContent = checkbox.nextSibling.textContent.trim();
                    selectedCategoriesList.appendChild(listItem);
                }
            });

            // Close the modal after saving changes
            const categoriesModal = new bootstrap.Modal(document.getElementById('categoriesModal'));
            categoriesModal.hide();
        });
    });
</script>
<script>
    const uploadUrl = "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@vite('resources/js/app.js')
@endsection

<!--Categories doesnt seem to be send with the little modal box that shows up when clicking submit!-->