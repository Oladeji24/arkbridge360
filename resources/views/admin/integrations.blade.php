@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Integration Analytics</h2>
    <div class="row">
        <div class="col-md-6">
            <h5>Google Analytics</h5>
            <pre>{{ print_r($googleStats, true) }}</pre>
        </div>
        <div class="col-md-6">
            <h5>Paystack Stats</h5>
            <pre>{{ print_r($paystackStats, true) }}</pre>
        </div>
    </div>
</div>
@endsection
