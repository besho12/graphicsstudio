<div class="faq-area-modern space-bottom overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="section-title text-center mb-60">
                    <h2 class="sec-title">{{ __('Frequently Asked Questions') }}</h2>
                    <p class="sec-text">{{ __('Find answers to common questions about our services and processes') }}</p>
                </div>
                <div class="faq-accordion-modern" id="faqAccordionModern">
                    @foreach ($faqs as $index => $faq)
                        <div class="faq-card-modern {{ $index == 0 ? 'active' : '' }}">
                            <div class="faq-header-modern" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index + 1 }}" 
                                 aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="faq-{{ $index + 1 }}">
                                <div class="faq-question">
                                    <span class="faq-number">{{ sprintf('%02d', $index + 1) }}</span>
                                    <h4 class="faq-title">{{ $faq?->question }}</h4>
                                </div>
                                <div class="faq-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div id="faq-{{ $index + 1 }}" class="faq-collapse {{ $index == 0 ? 'show' : '' }}" 
                                 data-bs-parent="#faqAccordionModern">
                                <div class="faq-body-modern">
                                    <p class="faq-answer">{{ $faq?->answer }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('frontend/js/faq-modern.js') }}"></script>