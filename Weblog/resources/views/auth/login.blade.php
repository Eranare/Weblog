<form method="POST" action="{{route ('login')}}">
    @csrf
    <input type="email" name="email" required autofocus>
    <input type="password" name="password" required>
    <button type="submit">Login</button>

</form>