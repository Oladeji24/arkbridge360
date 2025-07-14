@extends('layouts.app')

@section('title', 'Complete Payment - ArkBridge360')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4 class="mb-4">Pay ₦300 Securely with OPay</h4>
                    <form method="POST" action="{{ route('opay.init') }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
