@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Register</h2>
    <form method="POST" action="{{ route('register') }}" class="row g-3">
        @csrf
        <div class="col-12">
            <label for="type" class="form-label">Registration Type</label>
            <select id="type" name="type" class="form-select" required>
                <option value="adult">Adult</option>
                <option value="child">Child</option>
            </select>
        </div>
        <div id="adult-fields">
            <div class="col-md-6">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname">
            </div>
            <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
            </div>
            <div class="col-md-6">
                <label for="other_name" class="form-label">Other Name</label>
                <input type="text" class="form-control" id="other_name" name="other_name">
            </div>
            <div class="col-md-6">
                <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number">
            </div>
            <div class="col-md-6">
                <label for="alternate_number" class="form-label">Alternate Number</label>
                <input type="text" class="form-control" id="alternate_number" name="alternate_number">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-12">
                <label for="home_address" class="form-label">Home Address</label>
                <input type="text" class="form-control" id="home_address" name="home_address">
            </div>
        </div>
        <div id="child-fields" style="display:none;">
            <div class="col-12">
                <label for="full_name" class="form-label">Child's Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name">
            </div>
            <div class="col-12">
                <label for="guardian_name" class="form-label">Guardian Name</label>
                <input type="text" class="form-control" id="guardian_name" name="guardian_name">
            </div>
            <div class="col-md-6">
                <label for="guardian_phone" class="form-label">Guardian's Phone</label>
                <input type="text" class="form-control" id="guardian_phone" name="guardian_phone">
            </div>
            <div class="col-md-6">
                <label for="guardian_alternate" class="form-label">Guardian's Alternate Number</label>
                <input type="text" class="form-control" id="guardian_alternate" name="guardian_alternate">
            </div>
        </div>
        <div class="col-12">
            <label for="referral_code" class="form-label">Referral Code (optional)</label>
            <input type="text" class="form-control" id="referral_code" name="referral_code" value="{{ request('ref') }}">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Proceed to Payment</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('type').addEventListener('change', function() {
    var type = this.value;
    document.getElementById('adult-fields').style.display = (type === 'adult') ? 'block' : 'none';
    document.getElementById('child-fields').style.display = (type === 'child') ? 'block' : 'none';
});
window.addEventListener('DOMContentLoaded', function() {
    var type = document.getElementById('type').value;
    document.getElementById('adult-fields').style.display = (type === 'adult') ? 'block' : 'none';
    document.getElementById('child-fields').style.display = (type === 'child') ? 'block' : 'none';
});
</script>
@endsection
