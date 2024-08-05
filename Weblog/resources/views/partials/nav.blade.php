<nav>
    <ul>
        <p>nav</p>
        <li class="nav-item">
            <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" href="{{ route('home') }}">Home</a>
            <a class="nav-link @if(Route::currentRouteName() == '/categories/index') active @endif" href="{{ route('categories.index') }}">Categories</a>
        </li>
    </ul>

</nav>