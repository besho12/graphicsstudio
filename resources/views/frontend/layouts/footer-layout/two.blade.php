<footer class="footer-wrapper footer-layout2 bg-white overflow-hidden">
    <div class="container">
        <div class="widget-area space-top">
            <div class="row justify-content-between">
                <div class="col-md-6 col-xl-5 col-lg-6">
                    <div class="widget widget-newsletter footer-widget">
                        <h3 class="widget_title">{{__('Get valuable strategy, culture and brand insights straight to your inbox')}}</h3>
                        <form id="newsletter-form" action="{{route('newsletter-request')}}" class="newsletter-form">
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="example@gmail.com" required>
                            </div>
                            <button type="submit" class="btn subscribe_btn"><i class="fas fa-paper-plane"></i></button>
                        </form>
                        <p>{{__('By signing up to receive emails from Motto, you agree to our Privacy Policy. We treat your info responsibly.')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-xl-2 col-lg-3">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">{{__('Links')}}</h3>
                        <div class="menu-all-pages-container list-column2">
                            <ul class="menu">
                                @foreach (footerMenu() as $menu)
                                    <li><a @if($menu['open_new_tab']) target="_blank" @endif href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}"> {{ $menu['label'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-auto col-lg-4">
                    <div class="widget footer-widget widget-contact">
                        <h3 class="widget_title">{{__('Contact')}}</h3>
                        <ul class="contact-info-list">
                            <li>{{$contactSection?->address}}</li>
                            <li>
                                <a href="tel:{{$contactSection?->phone}}">{{$contactSection?->phone}}</a>
                                <a href="mailto:{{$contactSection?->email}}">{{$contactSection?->email}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright-wrap">
            <div class="row gy-3 justify-content-between align-items-center">
                <div class="col-md-6">
                    <p class="copyright-text">{{$setting?->copyright_text}}
                        <a href="{{route('home')}}">{{$setting?->app_name}}</a>
                    </p>

                </div>
                <div class="col-md-6 align-self-center">
                    <div class="social-btn style3 justify-content-md-end">
                        @foreach (socialLinks() as $social)
                            <a href="{{$social?->link}}">
                                <span class="link-effect">
                                    <span class="effect-1"><img class="social-icon" src="{{ asset($social?->icon) }}" alt="{{$social?->link}}"></span>
                                    <span class="effect-1"><img class="social-icon" src="{{ asset($social?->icon) }}" alt="{{$social?->link}}"></span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
