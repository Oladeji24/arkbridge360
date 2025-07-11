@extends('layouts.app')
@section('content')
<div class="container py-5 text-center">
    <h2 class="text-success">Registration Successful!</h2>
    <p>Thank you for joining ArtBridge360. Your payment was received and your registration is complete.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go to Homepage</a>
</div>
@endsection
