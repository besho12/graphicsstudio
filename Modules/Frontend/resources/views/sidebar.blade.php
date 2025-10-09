@use(App\Enums\ThemeList)
@if (Module::isEnabled('Frontend'))
    <li
        class="nav-item dropdown {{ isRoute(
            [
                'admin.hero-section.index',
                'admin.about-section.index',
                'admin.counter-section.index',
                'admin.choose-us-section.index',
                'admin.testimonial-section.index',
                'admin.contact-section.index',
                'admin.marquee.index',
                'admin.service-features-section.index',
            ],
            'active',
        ) }}">
        <a href="javascript:void()" class="nav-link has-dropdown"><i
                class="fas fa-puzzle-piece"></i><span>{{ __('Sections') }}</span></a>

        <ul class="dropdown-menu">
            {{-- Section nav list --}}
            @if (checkAdminHasPermission('section.management')) 
                @include('frontend::' . DEFAULT_HOMEPAGE . '.sidebar')
                {{-- Banner section removed --}}
                <li class="{{ isRoute('admin.counter-section.index', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.counter-section.index', ['code' => 'en']) }}">
                        {{ __('Counter Section') }}
                    </a>
                </li>
                <li class="{{ isRoute('admin.choose-us-section.index', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.choose-us-section.index', ['code' => 'en']) }}">
                        {{ __('Choose Us Section') }}
                    </a>
                </li>
                <li class="{{ isRoute('admin.brands-section.index', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.brands-section.index', ['code' => 'en']) }}">
                        {{ __('Brands Section') }}
                    </a>
                </li>
                {{-- <li class="{{ isRoute('admin.testimonial-section.index', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.testimonial-section.index') }}">
                        {{ __('Testimonial Section') }}
                    </a>
                </li> --}}
                <li class="{{ isRoute('admin.contact-section.index', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.contact-section.index') }}">
                        {{ __('Contact Page Section') }}
                    </a>
                </li>
            @endif
            {{-- Award section removed --}}
            @if (Module::isEnabled('Marquee') && checkAdminHasPermission('marquee.view'))
                @include('marquee::sidebar')
            @endif
        </ul>
    </li>
@endif
