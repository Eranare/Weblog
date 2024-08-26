<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weblog - @yield('title')</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    @if(auth()->check() && auth()->user()->role == 'admin')
    @include('writer.partials.nav')
    @endif
    @include('partials.nav')


    <div class="container mt-4">
        @yield('content')
    </div>


</body>

</html>