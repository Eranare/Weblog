<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <style>
        /* Custom styles for admin panel */
        .navbar-dark .navbar-brand {
            color: #fff;
        }

        .navbar-dark .nav-link {
            color: rgba(255, 255, 255, .75);
        }

        .navbar-dark .nav-link.active {
            color: #fff;
        }
    </style>
</head>

<body>
    @include('writer.partials.nav')
    @include('partials.nav')
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- jQuery and Bootstrap JS -->



</body>

</html>