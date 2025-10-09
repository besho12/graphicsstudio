<!--==============================
    Redesigned Service Area - Modern Style
    ==============================-->
<link rel="stylesheet" href="{{ asset('frontend/css/redesigned-service-cards.css') }}">

<div class="feature-area-1 space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <div class="title-area">
                    <h2 class="sec-title">{{ $serviceSection?->getTranslation(app()->getLocale())?->content?->title ?? __('What We Can Do for Our Clients') }}</h2>
                    @if($serviceSection?->getTranslation(app()->getLocale())?->content?->sub_title)
                        <p class="sec-subtitle mt-3">{{ $serviceSection?->getTranslation(app()->getLocale())?->content?->sub_title }}</p>
                    @else
                        <p class="sec-subtitle mt-3">{{ __('Discover our comprehensive range of professional services designed to elevate your business to new heights') }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="row g-4 justify-content-center">
            @foreach ($services->take(4) as $index => $service)
                <div class="col-lg-6 col-xl-3" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="feature-card-redesigned">
                        <!-- Service Icon -->
                        <div class="service-icon-container">
                            <div class="service-icon-bg"></div>
                            <div class="service-icon-inner">
                                <img src="{{ asset($service?->icon) }}" alt="{{ $service?->title }}">
                            </div>
                        </div>
                        
                        <!-- Service Content -->
                        <div class="service-content-redesigned">
                            <h4 class="service-title-redesigned">
                                <a href="{{ route('single.service', $service?->slug) }}">{{ $service?->title }}</a>
                            </h4>
                            <p class="service-description-redesigned">{{ Str::limit($service?->short_description, 120) }}</p>
                            
                            <!-- Action Button -->
                            <a href="{{ route('single.service', $service?->slug) }}" class="service-action-btn">
                                <span>{{ $service?->btn_text ?? 'Learn More' }}</span>
                                <svg class="btn-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- View All Services Button -->
        @if($services->count() > 4)
            <div class="text-center">
                <a href="{{ route('services') }}" class="view-all-services-btn">
                    <span>{{ __('View All Services') }}</span>
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h10.586l-2.293-2.293a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });
        }
    });
</script>