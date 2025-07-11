<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtBridge360</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional Custom CSS (if needed) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(90deg, #0056b3 60%, #ff9800 100%);
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar-brand span {
            color: #fff;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .hero {
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') center center/cover no-repeat;
            min-height: 400px;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 86, 179, 0.7);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .counter-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 2rem;
            text-align: center;
            margin-top: -60px;
        }
        .footer {
            background: #0056b3;
            color: #fff;
            padding: 2rem 0;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .navbar-brand span {
                font-size: 1.4rem;
            }
            .hero {
                min-height: 280px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" alt="ArtBridge360 Logo">
            <span>ArtBridge360</span>
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">Register</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('faq') }}">FAQ</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="display-4 fw-bold">Join ArtBridge360 Today</h1>
        <p class="lead">Connecting dreams, building bridges. Start your journey with us now.</p>
        <a href="{{ route('register') }}" class="btn btn-warning btn-lg mt-3">Get Started</a>
    </div>
</div>

<!-- Counter -->
<div class="container">
    <div class="counter-box mx-auto mt-5" style="max-width: 500px;">
        <h4 class="mb-3">Live Registration Count</h4>
        <div id="live-counter" class="display-6 fw-bold text-primary">0</div>
        <small class="text-muted">Updated every 5 seconds</small>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container text-center">
        <div class="mb-2">
            <a href="{{ route('faq') }}">FAQ</a> |
            <a href="#">Terms</a> |
            <a href="#">About</a>
        </div>
        <div class="small">&copy; {{ date('Y') }} ArtBridge360. All rights reserved.</div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateCounter() {
    fetch('/counter')
        .then(response => response.json())
        .then(data => {
            document.getElementById('live-counter').textContent = data.count;
        });
}
updateCounter();
setInterval(updateCounter, 5000);
</script>

</body>
</html>
