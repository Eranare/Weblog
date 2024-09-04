<!-- resources/views/partials/nav.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">Weblog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" href="{{ route('home') }}">Home</a>
            </li>
            <!-- Categories Dropdown in the Navbar -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarCategoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu p-3" aria-labelledby="navbarCategoriesDropdown" style="min-width: 300px;">
                    <!-- Search Input -->
                    <input type="text" id="categorySearch" class="form-control mb-3" placeholder="Search Categories">
                    
                    <!-- Default popular categories (top 6) -->
                    <div id="categoryResults">
                        <ul id="popularCategories" class="list-unstyled">
                            <!-- We'll dynamically add the top 6 categories here -->
                        </ul>
                    </div>
                </div>
            </li>

            <!--
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'articles.index') active @endif" href="{{ route('articles.index') }}">Articles</a>
            </li> -->
            @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.follows') }}">Followed Writers</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.subscribed') }}">Subbed Writers</a>
            </li>
            @endif
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
            @else
            <!-- Profile Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
            @endguest
        </ul>
    </div>
</nav>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySearch = document.getElementById('categorySearch');
    const popularCategories = document.getElementById('popularCategories');

    // Function to fetch top 6 popular categories when the page loads
    fetch('/api/categories/popular')
        .then(response => response.json())
        .then(categories => {
            popularCategories.innerHTML = ''; // Clear previous content
            categories.forEach(category => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `<a href="/categories/${category.id}" class="dropdown-item">${category.name}</a>`;
                popularCategories.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching popular categories:', error));

    // Search Categories as user types
    categorySearch.addEventListener('input', function() {
        const query = this.value;

        // If search input is empty, show popular categories again
        if (!query) {
            popularCategories.style.display = 'block';
            return;
        }

        fetch(`/api/categories/search?query=${query}`)
            .then(response => response.json())
            .then(categories => {
                popularCategories.innerHTML = ''; // Clear previous results
                if (categories.length === 0) {
                    popularCategories.innerHTML = '<li class="dropdown-item">No categories found</li>';
                } else {
                    categories.forEach(category => {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `<a href="/categories/${category.id}" class="dropdown-item">${category.name}</a>`;
                        popularCategories.appendChild(listItem);
                    });
                }
            })
            .catch(error => console.error('Error searching categories:', error));
    });
});
</script>