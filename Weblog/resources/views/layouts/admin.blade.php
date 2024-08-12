<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for admin panel */
        .navbar-dark .navbar-brand {
            color: #fff;
        }
        .navbar-dark .nav-link {
            color: rgba(255,255,255,.75);
        }
        .navbar-dark .nav-link.active {
            color: #fff;
        }
    </style>
</head>
<body>
    @include('admin.partials.nav')
    @include('partials.nav')
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
