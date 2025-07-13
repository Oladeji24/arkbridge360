<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArkBridge360')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Optional: Font Awesome or Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"> --}}
</head>
<body style="background-color: #f8f9fa;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #0056b3 60%, #ff9800 100%);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center text-white" href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" alt="Logo" height="40" class="me-2">
            <span class="fw-bold" style="font-size:1.8rem;letter-spacing:1px;">ArkBridge360</span>
        </a>

        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav text-white">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">Register</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('faq') }}">FAQ</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<main class="py-4">
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer mt-5" style="background: #0056b3; color: #fff; padding: 1.5rem 0;">
    <div class="container text-center">
        <div class="mb-2">
            <a href="{{ route('faq') }}" class="text-white mx-2">FAQ</a> |
            <a href="#" class="text-white mx-2">Terms</a> |
            <a href="#" class="text-white mx-2">About</a>
        </div>
        <div class="small">&copy; {{ date('Y') }} ArkBridge360. All rights reserved.</div>
        <div class="small mt-1">Powered by Gopher Crest Global Limited</div>
    </div>
</footer>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Page-Specific Scripts -->
@yield('scripts')

</body>
</html>
