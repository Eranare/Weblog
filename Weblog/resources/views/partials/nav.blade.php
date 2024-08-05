<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <p>nav</p>
            <li class="list-group-item">
                <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" href="{{ route('home') }}">Home</a>
            </li>
            <li class="list-group-item">
                <a class="nav-link @if(Route::currentRouteName() == '/categories/index') active @endif" href="{{ route('categories.index') }}">Categories</a>
            </li>
            <li class="list-group-item">
                <a class="nav-link @if(Route::currentRouteName() == '/articles/index') active @endif" href="{{ route('articles.index') }}">Articles</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profile
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">View profile</a>
                    <a class="dropdown-item" href="#">Subscription status</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Post Article</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Css this nav bar properly with bootstrap or tailwinds-->