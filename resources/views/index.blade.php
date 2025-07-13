@extends('layouts.app')

@section('title', 'ArkBridge360 - Connect Your Dreams')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="display-4 fw-bold">Join ArkBridge360 Today</h1>
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
@endsection

@section('scripts')
<script>
function updateCounter() {
    fetch('/counter')
        .then(response => response.json())
        .then(data => {
            document.getElementById('live-counter').textContent = data.count;
        })
        .catch(error => {
            console.error('Error fetching counter:', error);
        });
}
updateCounter();
setInterval(updateCounter, 5000);
</script>

<style>
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

    @media (max-width: 768px) {
        .hero {
            min-height: 280px;
        }
    }
</style>
@endsection
