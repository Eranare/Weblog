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
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'categories.index') active @endif" href="{{ route('categories.index') }}">Categories</a>
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