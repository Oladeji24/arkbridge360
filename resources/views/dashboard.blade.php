@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Dashboard</h2>
    @if($user)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Welcome, {{ $user['first_name'] ?? $user['full_name'] }}</h5>
                <p><strong>Referral Code:</strong> {{ $user['referral_code'] }}</p>
                <p><strong>Referral Count:</strong> {{ $referral_count }}</p>
                <p><strong>Payment Status:</strong> {{ $user['payment_status'] ?? 'pending' }}</p>
                <p><strong>Copy Referral URL:</strong> <input type="text" class="form-control d-inline-block w-auto" value="{{ url('/register?ref=' . $user['referral_code']) }}" readonly onclick="this.select()"></p>
            </div>
        </div>
    @else
        <div class="alert alert-danger">User not found.</div>
    @endif
</div>
@endsection
