@extends('layouts.app')

@section('title', 'Frequently Asked Questions - ArkBridge360')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="mb-4 text-primary fw-bold">Frequently Asked Questions</h2>

            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            📝 How do I register?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You can register by clicking the "Register" link in the menu or by visiting the <a href="{{ route('register') }}">registration page</a>.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            🔗 How does the referral system work?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            After registration, you’ll receive a referral code. Share it with others — when they register with your code, you earn referral points.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            💳 How do I make payments?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Payments are handled securely through OPay. After registration, you'll be redirected to complete your payment.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <p class="text-muted">Need more help? <a href="#">Contact support</a> or visit the <a href="#">About page</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
