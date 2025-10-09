@if (!$setting?->is_shop)
    <!-- Sidebar  -->
    @include('frontend.partials.sidebar-info')
@endif

<!-- Header Area -->
<header class="nav-header header-layout3 bg-white">
    <div class="sticky-wrapper">
        <!-- Main Menu Area -->
        <div class="menu-area">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ route('home') }}"><img src="{{ asset($setting?->logo) }}"
                                    alt="{{ $setting?->app_name }}"></a>
                        </div>
                    </div>
                    <div class="col-auto ms-auto">
                        <nav class="main-menu d-none d-lg-inline-block">
                            @include('frontend.partials.main-menu')
                        </nav>
                        <div class="navbar-right d-inline-flex d-lg-none">
                            <button type="button" class="menu-toggle sidebar-btn" aria-label="hamburger">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-button">
                            <!-- Modern Language Switcher -->
                            @include('frontend.partials.language-switcher', ['class' => 'desktop'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
@include('frontend.partials.mobile-menu')
