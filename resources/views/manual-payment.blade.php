@extends('layouts.app')

@section('title', 'Submit Payment - ArkBridge360')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Submit Payment Information</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-credit-card me-2 fs-4"></i>
                            <h5 class="mb-0">Bank Transfer Information</h5>
                        </div>
                        <div class="p-3 bg-white rounded border">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="mb-1 fw-bold">Account Number:</p>
                                    <p class="mb-3 fs-5">6110392668</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="mb-1 fw-bold">Bank:</p>
                                    <p class="mb-3 fs-5">OPay</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="mb-1 fw-bold">Account Name:</p>
                                    <p class="mb-0 fs-5">GOPHER CREST GLOBAL LIMITED</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('manual-payment.process') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name of Registrant</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="text" class="form-control" id="amount" value="300" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_for" class="form-label">Payment For</label>
                            <select class="form-select" id="payment_for" name="payment_for" required>
                                <option value="self">I am paying for myself</option>
                                <option value="other">I am paying for someone else</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select who you are paying for.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_code" class="form-label">Transaction Code / Reference Number</label>
                            <input type="text" class="form-control" id="transaction_code" name="transaction_code" placeholder="Enter the transaction reference number" required>
                            <div class="invalid-feedback">
                                Transaction code is required.
                            </div>
                            <small class="form-text text-muted">This is the reference number you received after making your bank transfer.</small>
                        </div>

                        <div class="mb-4">
                            <label for="receipt" class="form-label">Upload Receipt</label>
                            <input type="file" class="form-control" id="receipt" name="receipt" accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="invalid-feedback">
                                Please upload your payment receipt.
                            </div>
                            <small class="form-text text-muted">Accepted formats: JPG, PNG, PDF. Maximum size: 5MB.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">I Have Paid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Form validation
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // File size validation
    document.getElementById('receipt').addEventListener('change', function() {
        const fileSize = this.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 5) {
            this.setCustomValidity('File size must be less than 5MB');
            this.reportValidity();
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endsection
