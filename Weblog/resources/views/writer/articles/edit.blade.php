@extends('layouts.admin')
@section('title', 'Edit Article')

@section('content')
<div class="container">
    <h1>Edit Article</h1>

    <form action="{{ route('writer.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        Premium article: <input type="checkbox" name="is_premium" id="is_premium" value="1" {{ old('is_premium', $article->is_premium) ? 'checked' : '' }}>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="10">{{ old('content', $htmlContent) }}</textarea>
        </div>

        <!-- Hidden inputs for selected categories -->
        <div id="hiddenCategoriesContainer"></div>

        <!-- Button to Open the Modal for Categories -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriesModal">
            Category Tags
        </button>

        <!-- Categories selected display -->
        <div id="selectedCategories" class="mt-3">
            <strong>Selected Categories:</strong>
            <ul id="selectedCategoriesList">
                <!-- Selected categories will be listed here dynamically -->
            </ul>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Article</button>
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
                        <input type="checkbox" class="category-checkbox" name="categories[]" value="{{ $category->id }}" @if($article->categories->contains($category->id)) checked @endif> {{ $category->name }}
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
    document.addEventListener('DOMContentLoaded', function() {
        const saveCategoriesBtn = document.getElementById('saveCategoriesBtn');
        const selectedCategoriesList = document.getElementById('selectedCategoriesList');
        const hiddenCategoriesContainer = document.getElementById('hiddenCategoriesContainer');
        const checkboxes = document.querySelectorAll('.category-checkbox');

        // Preload selected categories when the page loads
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                // Display selected category on the main page
                const listItem = document.createElement('li');
                listItem.textContent = checkbox.nextSibling.textContent.trim();
                selectedCategoriesList.appendChild(listItem);

                // Create hidden input for form submission
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'categories[]';
                hiddenInput.value = checkbox.value;
                hiddenCategoriesContainer.appendChild(hiddenInput);
            }
        });

        // Handle the "Save changes" button click
        saveCategoriesBtn.addEventListener('click', function() {
            // Clear existing hidden inputs and selected categories display
            hiddenCategoriesContainer.innerHTML = '';
            selectedCategoriesList.innerHTML = '';

            // Iterate over checkboxes and handle selected categories
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    // Create hidden input for form submission
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'categories[]';
                    hiddenInput.value = checkbox.value;
                    hiddenCategoriesContainer.appendChild(hiddenInput);

                    // Display selected category on the main page
                    const listItem = document.createElement('li');
                    listItem.textContent = checkbox.nextSibling.textContent.trim();
                    selectedCategoriesList.appendChild(listItem);
                }
            });

            // Do not close the modal here; let the user close it manually
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