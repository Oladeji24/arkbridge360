@extends('layouts.app')

@section('title', 'Why Join ArkBridge360')

@section('content')
<div class="container py-5">
    <div class="animation-bg"></div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-4">Why Join ArkBridge360?</h1>
                <p class="lead">Discover how we're changing lives across Nigeria</p>
            </div>

            <div class="explanation-points">
                <!-- Point 1 -->
                <div class="explanation-point" id="point1">
                    <div class="point-number">1</div>
                    <div class="point-content">
                        <h2 class="point-title">
                            <span class="icon">🌉</span> ArkBridge360 is a Bridge from Pennies to Profits
                        </h2>
                        <p class="point-description">
                            It's a people-powered platform that connects everyday Nigerians to real business projects, 
                            cooperative investments, and life-changing opportunities with as little as ₦300.
                        </p>
                    </div>
                </div>

                <!-- Point 2 -->
                <div class="explanation-point" id="point2">
                    <div class="point-number">2</div>
                    <div class="point-content">
                        <h2 class="point-title">
                            <span class="icon">💼</span> We Create Shared Wealth Through Cooperative Ventures
                        </h2>
                        <p class="point-description">
                            From exporting raw materials to strategic investments, ArkBridge360 allows 1,000,000 
                            participants to benefit from profit-sharing, cash rewards, and sustainable business growth.
                        </p>
                    </div>
                </div>

                <!-- Point 3 -->
                <div class="explanation-point" id="point3">
                    <div class="point-number">3</div>
                    <div class="point-content">
                        <h2 class="point-title">
                            <span class="icon">🎯</span> Built for Nigerians, Powered by Purpose
                        </h2>
                        <p class="point-description">
                            We empower members with access to income, startup funding, and long-term equity—backed by 
                            transparency, community ownership, and future-focused initiatives.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg continue-btn">
                    Continue to Registration
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to check if an element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Enhanced animation sequence
        const runAnimations = () => {
            // Header animations
            const header = document.querySelector('.text-center.mb-5');
            header.style.opacity = "0";
            header.style.transform = "translateY(-20px)";

            setTimeout(() => {
                header.style.transition = "opacity 1s ease, transform 1s ease";
                header.style.opacity = "1";
                header.style.transform = "translateY(0)";
            }, 300);

            // Point animations with staggered reveal of icon, title, and description
            const points = document.querySelectorAll('.explanation-point');

            points.forEach((point, index) => {
                // Initially hide all elements
                const pointElements = {
                    number: point.querySelector('.point-number'),
                    title: point.querySelector('.point-title'),
                    description: point.querySelector('.point-description'),
                };

                Object.values(pointElements).forEach(el => {
                    el.style.opacity = "0";
                    el.style.transition = "opacity 0.8s ease, transform 0.8s ease";
                });

                // Staggered animation timing
                const baseDelay = 800 + (index * 1000);

                // Animate point container
                setTimeout(() => {
                    point.classList.add('visible');

                    // Animate point number with slight bounce
                    setTimeout(() => {
                        pointElements.number.style.opacity = "1";
                        pointElements.number.style.transform = "scale(1.2)";
                        setTimeout(() => {
                            pointElements.number.style.transform = "scale(1)";
                        }, 200);
                    }, 200);

                    // Animate title with fade
                    setTimeout(() => {
                        pointElements.title.style.opacity = "1";
                        pointElements.title.style.transform = "translateX(0)";
                    }, 400);

                    // Animate description with fade
                    setTimeout(() => {
                        pointElements.description.style.opacity = "1";
                    }, 700);

                }, baseDelay);
            });

            // Continue button animation with enhanced effect
            setTimeout(() => {
                const continueBtn = document.querySelector('.continue-btn');
                continueBtn.style.opacity = "0";
                continueBtn.style.transform = "translateY(20px)";
                continueBtn.style.transition = "opacity 1s ease, transform 1s ease";

                setTimeout(() => {
                    continueBtn.style.opacity = "1";
                    continueBtn.style.transform = "translateY(0)";

                    // Add pulse effect after appearing
                    setTimeout(() => {
                        continueBtn.classList.add('pulse');
                    }, 1000);
                }, 300);
            }, 4000);
        };

        // Run the animation sequence
        runAnimations();

        // Add scroll-based animations for when user scrolls
        window.addEventListener('scroll', () => {
            const points = document.querySelectorAll('.explanation-point');
            points.forEach(point => {
                if (isInViewport(point) && !point.classList.contains('visible')) {
                    point.classList.add('visible');
                }
            });
        });
    });
</script>

<style>
    .explanation-points {
        margin: 3rem 0;
    }

    .explanation-point {
        display: flex;
        margin-bottom: 3rem;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }

    .explanation-point.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .explanation-point .point-title {
        transform: translateX(-15px);
    }

    .point-number {
        background: linear-gradient(135deg, #4a90e2, #2d67c9);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-right: 1.5rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(45, 103, 201, 0.3);
    }

    .point-content {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        flex-grow: 1;
    }

    .point-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
        display: flex;
        align-items: center;
    }

    .point-title .icon {
        font-size: 1.8rem;
        margin-right: 0.5rem;
    }

    .point-description {
        font-size: 1.1rem;
        color: #555;
        line-height: 1.6;
    }

    .continue-btn {
        font-size: 1.2rem;
        padding: 0.8rem 2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        background: linear-gradient(135deg, #4a90e2, #2d67c9);
        border: none;
    }

    .continue-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .continue-btn.pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(74, 144, 226, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(74, 144, 226, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(74, 144, 226, 0);
        }
    }

    .animation-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(74, 144, 226, 0.05) 100%);
        z-index: -1;
        overflow: hidden;
    }

    .animation-bg:before,
    .animation-bg:after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(74, 144, 226, 0.05);
        animation: float 15s infinite ease-in-out;
    }

    .animation-bg:before {
        top: -100px;
        left: -100px;
        animation-delay: 0s;
    }

    .animation-bg:after {
        bottom: -100px;
        right: -100px;
        width: 250px;
        height: 250px;
        animation-delay: -7.5s;
    }

    @keyframes float {
        0%, 100% {
            transform: translate(0, 0);
        }
        25% {
            transform: translate(50px, 50px);
        }
        50% {
            transform: translate(100px, 0);
        }
        75% {
            transform: translate(50px, -50px);
        }
    }

    @media (max-width: 768px) {
        .explanation-point {
            flex-direction: column;
        }

        .point-number {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection