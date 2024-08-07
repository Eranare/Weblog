<form method="POST" action="{{route ('login')}}">
    @csrf
    <input type="email" name="email" required autofocus>
    <input type="password" name="password" required>
    <button type="submit">Login</button>

</form>


<a class="nav-link" href="{{ route('home') }}"><button>back to main menu</button></a>