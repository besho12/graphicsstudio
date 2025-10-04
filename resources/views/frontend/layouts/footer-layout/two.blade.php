<footer class="footer-wrapper footer-layout2-modern overflow-hidden">
    <!-- Main Footer Content -->
    <div class="footer-main-section">
        <div class="container">
            <div class="row g-5">
                <!-- Company Info & Newsletter Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-company-section">
                        <!-- Company Logo & Description -->
                        <div class="footer-brand-modern">
                            <div class="footer-logo-wrapper">
                                <img src="{{ asset($setting?->logo) }}" alt="{{$setting?->app_name}}" class="footer-logo-modern">
                            </div>
                            <h3 class="company-name">{{$setting?->app_name}}</h3>
                            <p class="company-description">{{__('Creating exceptional digital experiences through innovative design and strategic thinking.')}}</p>
                        </div>
                        
                        <!-- Newsletter Signup -->
                        <div class="footer-newsletter-compact">
                            <h4 class="newsletter-title-small">{{__('Stay Updated')}}</h4>
                            <form id="newsletter-form" action="{{route('newsletter-request')}}" class="newsletter-form-compact">
                                <div class="input-group-compact">
                                    <input class="form-control-compact" type="email" name="email" placeholder="Your email" required>
                                    <button type="submit" class="btn-subscribe-compact">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer-links-section">
                        <h4 class="footer-title-modern">{{__('Quick Links')}}</h4>
                        <ul class="footer-menu-organized">
                            @foreach (footerMenu() as $menu)
                                <li>
                                    <a @if($menu['open_new_tab']) target="_blank" @endif 
                                       href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}" 
                                       class="footer-link-clean">
                                        {{ $menu['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Services Links -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer-services-section">
                        <h4 class="footer-title-modern">{{__('Services')}}</h4>
                        <ul class="footer-menu-organized">
                            <li><a href="#" class="footer-link-clean">Web Design</a></li>
                            <li><a href="#" class="footer-link-clean">Branding</a></li>
                            <li><a href="#" class="footer-link-clean">Digital Marketing</a></li>
                            <li><a href="#" class="footer-link-clean">Development</a></li>
                            <li><a href="#" class="footer-link-clean">Consulting</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact & Social -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-contact-section">
                        <h4 class="footer-title-modern">{{__('Get In Touch')}}</h4>
                        
                        <!-- Contact Information -->
                        <div class="contact-info-organized">
                            @if($contactSection?->address)
                            <div class="contact-item-clean">
                                <i class="fas fa-map-marker-alt contact-icon-small"></i>
                                <span class="contact-text">{{$contactSection->address}}</span>
                            </div>
                            @endif

                            @if($contactSection?->phone)
                            <div class="contact-item-clean">
                                <i class="fas fa-phone-alt contact-icon-small"></i>
                                <a href="tel:{{$contactSection->phone}}" class="contact-link-clean">{{$contactSection->phone}}</a>
                            </div>
                            @endif

                            @if($contactSection?->email)
                            <div class="contact-item-clean">
                                <i class="fas fa-envelope contact-icon-small"></i>
                                <a href="mailto:{{$contactSection->email}}" class="contact-link-clean">{{$contactSection->email}}</a>
                            </div>
                            @endif
                        </div>

                        <!-- Social Media -->
                        <div class="social-section-organized">
                            <h5 class="social-title">{{__('Follow Us')}}</h5>
                            <div class="social-links-organized">
                                @foreach (socialLinks() as $social)
                                    <a href="{{$social?->link}}" class="social-link-clean" target="_blank">
                                        <img src="{{ asset($social?->icon) }}" alt="{{$social?->link}}" class="social-icon-small">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom-modern">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="copyright-modern">
                        <p class="copyright-text-modern">
                            {{$setting?->copyright_text}}
                            <a href="{{route('home')}}" class="copyright-link-modern">{{$setting?->app_name}}</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-legal-modern">
                        <a href="#" class="legal-link-modern">Privacy Policy</a>
                        <span class="separator">|</span>
                        <a href="#" class="legal-link-modern">Terms of Service</a>
                        <span class="separator">|</span>
                        <a href="#" class="legal-link-modern">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
