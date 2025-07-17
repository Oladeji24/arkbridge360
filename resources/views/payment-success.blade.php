@extends('layouts.app')

@section('title', 'Payment Submitted - ArkBridge360')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    <h2 class="mb-3">Thank You!</h2>
                    <p class="mb-4 text-muted">Your payment information has been submitted successfully and is pending verification.</p>
                    <p class="mb-4">We've sent a welcome email to your registered email address with important information about your ArkBridge360 journey.</p>
                    <p class="mb-4">Once your payment is verified, you will receive an additional confirmation notification.</p>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
