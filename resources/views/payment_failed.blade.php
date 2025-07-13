@extends('layouts.app')

@section('title', 'Payment Failed - ArkBridge360')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Payment Failed</h4>
                </div>
                <div class="card-body text-center">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @else
                        <p class="mb-3">We could not process your payment at this time.</p>
                    @endif

                    <p>Please check your payment details and try again.</p>

                    <div class="mt-4">
                        <a href="{{ route('opay.pay') }}" class="btn btn-primary">Try Again</a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection