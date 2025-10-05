@if (!$setting?->is_shop)
    <!-- Sidebar  -->
    @include('frontend.partials.sidebar-info')
@endif

<!-- FADA.A Exact Navigation -->
<header class="fada-header">
    <div class="fada-header-container">
        <!-- Logo Section -->
        <div class="fada-logo">
            <a href="{{ route('home') }}" class="fada-logo-link">
                @if(!empty($setting?->logo))
                    <img src="{{ asset($setting?->logo) }}" alt="{{ $setting?->app_name }}">
                @else
                    <div class="fada-logo-text">
                        FADA<span class="fada-logo-accent">.</span>A
                    </div>
                @endif
            </a>
        </div>

        <!-- Main Navigation Menu -->
        <nav class="fada-main-nav d-none d-lg-block">
            @include('frontend.partials.main-menu')
        </nav>

        <!-- Language Selector -->
        <div class="fada-language-selector d-none d-lg-block">
            @if (allLanguages()?->where('status', 1)->count() > 1)
                <form class="fada-language-form" action="{{ route('set-language') }}" method="get">
                    <select class="fada-language-select" name="code" onchange="this.form.submit()">
                        @forelse (allLanguages()?->where('status', 1) as $language)
                            <option value="{{ $language->code }}"
                                {{ getSessionLanguage() == $language->code ? 'selected' : '' }}>
                                {{ $language->name }}
                            </option>
                        @empty
                            <option value="en"
                                {{ getSessionLanguage() == 'en' ? 'selected' : '' }}>
                                {{ __('English') }}
                            </option>
                        @endforelse
                    </select>
                </form>
            @endif
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="fada-mobile-toggle d-lg-none" id="fadaMobileToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Mobile Navigation -->
    <div class="fada-mobile-nav" id="fadaMobileNav">
        <ul class="fada-mobile-menu">
            @foreach(mainMenu() as $menu)
                <li class="fada-mobile-item {{ !empty($menu['child']) ? 'has-dropdown' : '' }}">
                    <a href="{{ $menu['url'] ?? '#' }}" class="fada-mobile-link">{{ $menu['title'] ?? '' }}</a>
                    @if(!empty($menu['child']))
                        <ul class="fada-mobile-dropdown">
                            @foreach($menu['child'] as $child)
                                <li><a href="{{ $child['url'] ?? '#' }}">{{ $child['title'] ?? '' }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>

        @if (allLanguages()?->where('status', 1)->count() > 1)
            <div class="fada-mobile-lang">
                @foreach(allLanguages()?->where('status', 1) as $language)
                    <a href="{{ route('set-language', $language->code) }}" 
                       class="fada-mobile-lang-option {{ getSessionLanguage() == $language->code ? 'active' : '' }}">
                        {{ $language->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</header>
