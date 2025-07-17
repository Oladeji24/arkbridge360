@extends('layouts.app')

@section('title', 'Frequently Asked Questions - ArkBridge360')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="mb-4 text-primary fw-bold">ArkBridge360 – Frequently Asked Questions (FAQ)</h2>
            <p class="text-center mb-4">Powered by Gopher Crest Global Limited</p>

            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            1. What is ArkBridge360?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            ArkBridge360 is a people-powered investment and cooperative platform that connects Nigerians to long-term business ventures, such as raw material exportation and enterprise funding. It aims to create shared wealth, financial freedom, and lasting economic impact.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            2. What do I get by registering with ₦300?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            With just ₦300, you gain:
                            <ul>
                                <li>A lifetime membership in the ArkBridge360 community</li>
                                <li>Access to future passive income through profit-sharing</li>
                                <li>Eligibility for rewards, grants, and business support</li>
                                <li>Participation in our 6–12 month life-rewarding roadmap</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            3. Is ArkBridge360 a one-time payment or ongoing contribution?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            The ₦300 is a one-time registration fee. There may be optional contribution windows in the future for those who wish to invest more, but it's never compulsory.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            4. What kind of business does ArkBridge360 engage in?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We focus on exportation of raw materials, strategic local investments, and cooperative-led projects that generate income. Profits are reinvested and partially shared with participants.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                            5. How are participants rewarded?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Participants may benefit from:
                            <ul>
                                <li>Annual profit distribution (after expenses)</li>
                                <li>Monthly random picks for rewards (after 6 months)</li>
                                <li>Cash grants, startup support, and business tool</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            6. What is the 1,000,000 participant goal?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Our benchmark is to build a network of 1 million registered Nigerians. Once reached, the platform locks registration and begins rewarding and empowering the selected and active members.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven">
                            7. Is ArkBridge360 a long-term project?
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. ArkBridge360 is designed for long-term impact. Initial rewards begin from 6 months, with more structured benefits rolling out over 12–24 months and beyond.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight">
                            8. How secure and legal is this project?
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            ArkBridge360 is backed by Gopher Crest Global Limited, with efforts in place to align with regulatory bodies such CAC and has is SCUML. We operate with transparency and legal compliance to the core.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNine">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine">
                            9. Will there be a raffle draw or competition?
                        </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes! A special referral competition rewards the top 3 committed participants with:
                            <ul>
                                <li>₦2,500,000 – 1<sup>st</sup> Place</li>
                                <li>₦1,500,000 – 2<sup>nd</sup> Place</li>
                                <li>₦1,000,000 – 3<sup>rd</sup> Place</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen">
                            10. How do I stay updated after registration?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Participants will receive updates via:
                            <ul>
                                <li>Our official mobile app or dashboard</li>
                                <li>WhatsApp group channels</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEleven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven">
                            11. Is this a Ponzi or money-doubling scheme?
                        </button>
                    </h2>
                    <div id="collapseEleven" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Absolutely not. ArkBridge360 is not a quick-profit scheme. It is a cooperative and investment platform focused on business, sustainability, and shared success.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwelve">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve">
                            12. How can I contact ArkBridge360?
                        </button>
                    </h2>
                    <div id="collapseTwelve" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Visit: <a href="http://www.arkbridge360.com.ng" target="_blank">www.arkbridge360.com.ng</a></li>
                                <li>Email: <a href="mailto:support@Arkbridge360.com.ng">support@Arkbridge360.com.ng</a></li>
                                <li>Phone: 08035594843, 07066863569</li>
                                <li>Social Media: @ArkBridge360 on Facebook, Instagram</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <p class="text-muted">Need more help? <a href="mailto:support@Arkbridge360.com.ng">Contact support</a> or visit our social media pages.</p>
            </div>
        </div>
    </div>
</div>
@endsection