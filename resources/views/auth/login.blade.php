@extends('layouts.app')

@section('title', 'Login - ArkBridge360')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Login</h2>
    <form method="POST" action="{{ route('login') }}" class="row g-3">
        @csrf
        <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </form>
</div>
@endsection
