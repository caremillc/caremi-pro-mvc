<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Careminate Framework')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-light text-dark">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <a class="navbar-brand" href="/">Careminate</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/about">About</a>
                <a class="nav-link" href="/users/1">Profile</a>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        @yield('content')
    </main>

    @stack('scripts')
<footer class="text-center mt-5 py-3 border-top">
    <small>&copy; {{ date('Y') }} Careminate Framework</small>
</footer>
</body>
</html>
