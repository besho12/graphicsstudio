<footer class="footer-wrapper footer-layout4 footer-modern overflow-hidden">
    <div class="container">
        <div class="widget-area footer-content-modern">
            <div class="row justify-content-between">
                <div class="col-md-6 col-xl-5 col-lg-6">
                    <div class="widget widget-about footer-widget footer-widget-modern">
                        <div class="footer-logo footer-logo-modern">
                            <a href="{{ route('home') }}"><img src="{{ asset($setting?->logo) }}"
                                alt="{{ $setting?->app_name }}"></a>
                        </div>
                        <p class="about-text footer-description">{{__('If you ask our clients what it\'s like working with us, they\'ll talk about how much we care about their success. Strong relationships fuel real success. We love building brands.')}}</p>
                        <div class="social-btn style3 social-links-modern">
                            @foreach (socialLinks() as $social)
                            <a href="{{ $social?->link }}" class="social-link-modern">
                                <span class="link-effect">
                                    <span class="effect-1"><img class="social-icon" src="{{ asset($social?->icon) }}" alt="{{$social?->link}}"></span>
                                    <span class="effect-1"><img class="social-icon" src="{{ asset($social?->icon) }}" alt="{{$social?->link}}"></span>
                                </span>
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-2 col-lg-3">
                    <div class="widget widget_nav_menu footer-widget footer-widget-modern">
                        <h3 class="widget_title footer-title-modern">{{__('Links')}}</h3>
                        <div class="menu-all-pages-container list-column2">
                            <ul class="menu footer-menu-modern">
                                @foreach (footerMenu() as $menu)
                                    <li><a @if($menu['open_new_tab']) target="_blank" @endif href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}" class="footer-link-modern"> {{ $menu['label'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-auto col-lg-4">
                    <div class="widget footer-widget footer-widget-modern widget-contact">
                        <h3 class="widget_title footer-title-modern">{{__('Contact')}}</h3>
                        <ul class="contact-info-list contact-info-modern">
                            <li class="contact-item-modern">{{$contactSection?->address}}</li>
                            <li class="contact-item-modern">
                                <a href="tel:{{$contactSection?->phone}}" class="contact-link-modern">{{$contactSection?->phone}}</a>
                                <a href="mailto:{{$contactSection?->email}}" class="contact-link-modern">{{$contactSection?->email}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright-wrap copyright-modern">
            <div class="row gy-3 justify-content-center align-items-center text-center">
                <div class="col-md-12">
                    <p class="copyright-text copyright-text-modern">
                        <a href="https://hamdiesolutions.com/" class="copyright-link-modern" target="_blank">Powered by © Hamdies Solutions</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>