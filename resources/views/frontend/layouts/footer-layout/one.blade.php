<footer class="footer-wrapper footer-layout1 overflow-hidden modern-footer">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="footer-main-content space">
            <div class="row">
                <!-- Company Info Section -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-company-info">
                        <div class="footer-logo mb-4">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset($setting?->logo) }}" alt="{{ $setting?->app_name }}" class="footer-logo-img">
                            </a>
                        </div>
                        <p class="footer-description mb-4">
                            {{ __('We are digital agency that helps businesses develop immersive and engaging user experiences that drive top level growth') }}
                        </p>
                        <div class="footer-social-links">
                            @foreach (socialLinks() as $social)
                                <a href="{{ $social?->link }}" class="social-link-modern" target="_blank">
                                    <img class="social-icon" src="{{ asset($social?->icon) }}" alt="{{$social?->link}}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Links Section -->
                <div class="col-lg-2 col-md-6 mb-5">
                    <div class="footer-links-section">
                        <h4 class="footer-section-title">{{ __('Quick Links') }}</h4>
                        <ul class="footer-links-list">
                            @foreach (footerMenu()->take(4) as $menu)
                                <li>
                                    <a @if ($menu['open_new_tab']) target="_blank" @endif
                                        href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}"
                                        class="footer-link">
                                        {{ $menu['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="col-lg-2 col-md-6 mb-5">
                    <div class="footer-links-section">
                        <h4 class="footer-section-title">{{ __('Services') }}</h4>
                        <ul class="footer-links-list">
                            @foreach (footerSecondMenu()->take(4) as $menu)
                                <li>
                                    <a @if ($menu['open_new_tab']) target="_blank" @endif
                                        href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}"
                                        class="footer-link">
                                        {{ $menu['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Contact CTA Section -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-cta-section">
                        <h3 class="footer-cta-title">{{ __('Let's Work Together') }}</h3>
                        <p class="footer-cta-text mb-4">
                            {{ __('Ready to start your next project? Get in touch with us today.') }}
                        </p>
                        <a href="{{ route('contact') }}" class="footer-cta-btn">
                            <span class="btn-text">{{ __('Start Project') }}</span>
                            <span class="btn-icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M1 8H15M15 8L8 1M15 8L8 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright-text">
                        {{ $setting?->copyright_text }} <a href="{{ route('home') }}" class="copyright-link">{{ $setting?->app_name }}</a>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-bottom-links">
                        <a href="/privacy-policy" class="footer-bottom-link">{{ __('Privacy Policy') }}</a>
                        <a href="/terms-of-service" class="footer-bottom-link">{{ __('Terms of Service') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
