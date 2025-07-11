@extends('layouts.app')
@section('content')
<div class="container py-5 text-center">
    <h2 class="text-danger">Payment Failed</h2>
    <p>Sorry, your payment could not be verified. Please try again or contact support.</p>
    <a href="{{ route('register') }}" class="btn btn-warning mt-3">Try Again</a>
</div>
@endsection
