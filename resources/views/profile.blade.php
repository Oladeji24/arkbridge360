@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Edit Profile</h2>
    @if($user)
    <form method="POST" action="{{ route('profile') }}" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user['first_name'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ $user['surname'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="other_name" class="form-label">Other Name</label>
            <input type="text" class="form-control" id="other_name" name="other_name" value="{{ $user['other_name'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
            <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ $user['whatsapp_number'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="alternate_number" class="form-label">Alternate Number</label>
            <input type="text" class="form-control" id="alternate_number" name="alternate_number" value="{{ $user['alternate_number'] ?? '' }}">
        </div>
        <div class="col-12">
            <label for="home_address" class="form-label">Home Address</label>
            <input type="text" class="form-control" id="home_address" name="home_address" value="{{ $user['home_address'] ?? '' }}">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
    @else
        <div class="alert alert-danger">User not found.</div>
    @endif
    @if(session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif
</div>
@endsection
