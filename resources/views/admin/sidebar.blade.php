<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}"><img class="w-75" src="{{ asset($setting->logo) ?? '' }}"
                    alt="{{ $setting->app_name ?? '' }}"></a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset($setting->favicon) ?? '' }}"
                    alt="{{ $setting->app_name ?? '' }}"></a>
        </div>

        <ul class="sidebar-menu">
            {{-- @adminCan('dashboard.view')
                <li class="{{ isRoute('admin.dashboard', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endadminCan --}}

            @if (checkAdminHasPermission('blog.category.view') ||
                    checkAdminHasPermission('blog.view') ||
                    checkAdminHasPermission('blog.comment.view') ||
                    checkAdminHasPermission('pricing.view') ||
                    checkAdminHasPermission('customer.view') ||
                    checkAdminHasPermission('team.management'))

                <li class="menu-header">{{ __('Manage Contents') }}</li>

                @if (Module::isEnabled('Blog')  && 1 == 2 )
                    @include('blog::sidebar')
                @endif

                @if (Module::isEnabled('Subscription') && checkAdminHasPermission('pricing.view'))
                    @include('subscription::admin.sidebar')
                @endif

                @if (Module::isEnabled('OurTeam')   && 1 == 2 && checkAdminHasPermission('team.management'))
                    @include('ourteam::sidebar')
                @endif

                @if (Module::isEnabled('Customer') && 1 == 2  && checkAdminHasPermission('customer.view'))
                    @include('customer::sidebar')
                @endif
            @endif
            @if (Module::isEnabled('Service') && checkAdminHasPermission('service.view'))
                @include('service::sidebar')
            @endif
            @if (Module::isEnabled('Project') && checkAdminHasPermission('project.view'))
                @include('project::sidebar')
            @endif

            @if (checkAdminHasPermission('menu.view') ||
                    checkAdminHasPermission('page.view') ||
                    checkAdminHasPermission('faq.view') ||
                    checkAdminHasPermission('social.link.management'))
                <li class="menu-header">{{ __('Manage Website') }}</li>

                @if (Module::isEnabled('CustomMenu')  && 1 == 2 && checkAdminHasPermission('menu.view'))
                    @include('custommenu::sidebar')
                @endif

                @if (Module::isEnabled('PageBuilder') && 1 == 2  && checkAdminHasPermission('page.view'))
                    @include('pagebuilder::sidebar')
                @endif

                @if (Module::isEnabled('Faq') && checkAdminHasPermission('faq.view'))
                    @include('faq::sidebar')
                @endif

                @if (Module::isEnabled('SocialLink') && checkAdminHasPermission('social.link.management'))
                    @include('sociallink::sidebar')
                @endif
            @endif


            @if (checkAdminHasPermission('coupon.management') ||
                    checkAdminHasPermission('order.management') ||
                    checkAdminHasPermission('shipping.method.view') ||
                    checkAdminHasPermission('refund.management') ||
                    checkAdminHasPermission('country.view') ||
                    checkAdminHasPermission('product.category.management') ||
                    checkAdminHasPermission('product.management') ||
                    checkAdminHasPermission('product.review.management'))
                @if ($setting?->is_shop  && 1 == 2 )
                    <li class="menu-header">{{ __('Shop') }}</li>

                    <li
                        class="nav-item dropdown {{ isRoute(['admin.product.*', 'admin.product-review.*'], 'active') }}">
                        <a href="javascript:;" class="nav-link has-dropdown">
                            <i class="fas fa-store-alt"></i><span>{{ __('Manage Shop') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @if (Module::isEnabled('Shop') && 1 == 2  &&
                                    (checkAdminHasPermission('product.category.management') ||
                                        checkAdminHasPermission('product.management') ||
                                        checkAdminHasPermission('product.review.management')))
                                @include('shop::sidebar')
                            @endif
                        </ul>
                    </li>

                    @if (Module::isEnabled('Coupon')  && 1 == 2 && checkAdminHasPermission('coupon.management'))
                        @include('coupon::sidebar')
                    @endif

                    @if (Module::isEnabled('Order') && 1 == 2  &&
                            (checkAdminHasPermission('order.management') || checkAdminHasPermission('shipping.method.view')))
                        @include('order::sidebar')
                    @endif

                    @if (Module::isEnabled('Refund') && 1 == 2  && checkAdminHasPermission('refund.management'))
                        @include('refund::admin.sidebar')
                    @endif
                @endif
                @if (Module::isEnabled('Location') && checkAdminHasPermission('country.view'))
                    @include('location::sidebar')
                @endif
            @endif
            @if (checkAdminHasPermission('appearance.management') ||
                    checkAdminHasPermission('section.management') ||
                    checkAdminHasPermission('brand.management'))
                <li class="menu-header">{{ __('Site Contents') }}</li>
                {{-- @if (Module::isEnabled('SiteAppearance') && checkAdminHasPermission('appearance.management'))
                    @include('siteappearance::sidebar')
                @endif --}}

                @if (Module::isEnabled('Frontend') &&
                        (checkAdminHasPermission('section.management') ||
                            checkAdminHasPermission('marquee.view') ||
                            checkAdminHasPermission('award.view')))
                    @include('frontend::sidebar')
                @endif
                @if (Module::isEnabled('Brand') && checkAdminHasPermission('brand.management'))
                    @include('brand::sidebar')
                @endif
            @endif

            @if (checkAdminHasPermission('setting.view') ||
                    checkAdminHasPermission('basic.payment.view') ||
                    checkAdminHasPermission('currency.view') ||
                    checkAdminHasPermission('tax.view') ||
                    checkAdminHasPermission('language.view') ||
                    checkAdminHasPermission('addon.view') ||
                    checkAdminHasPermission('role.view') ||
                    checkAdminHasPermission('admin.view'))
                <li class="menu-header">{{ __('Settings') }}</li>

                @if (Module::isEnabled('GlobalSetting'))
                    <li class="{{ isRoute('admin.settings', 'active') }}">
                        <a class="nav-link" href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                    </li>
                @endif
            @endif

            @if (checkAdminHasPermission('newsletter.view') ||
                    checkAdminHasPermission('newsletter.mail') ||
                    checkAdminHasPermission('testimonial.view') ||
                    checkAdminHasPermission('contact.message.view'))
                <li class="menu-header">{{ __('Utility') }}</li>


                @if (Module::isEnabled('NewsLetter') && 1 == 2  &&
                        (checkAdminHasPermission('newsletter.view') || checkAdminHasPermission('newsletter.mail')))
                    @include('newsletter::sidebar')
                @endif

                {{-- @if (Module::isEnabled('Testimonial') && checkAdminHasPermission('testimonial.view'))
                    @include('testimonial::sidebar')
                @endif --}}

                @if (Module::isEnabled('ContactMessage') && checkAdminHasPermission('contact.message.view'))
                    @include('contactmessage::sidebar')
                @endif
            @endif
            {{-- <li class="nav-item dropdown {{ isRoute('admin.addon.*') ? 'active' : '' }}" id="addon_sidemenu">
                <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-gem"></i>
                    <span>{{ __('Manage Addons') }} </span>
    
                </a>
                <ul class="dropdown-menu addon_menu">
    
                    @includeIf('admin.addons')
                </ul>
            </li> --}}
        </ul>
        <div class="py-3 text-center">
            <div class="btn-sm-group-vertical version_button" role="group" aria-label="Responsive button group">
                <button class="btn btn-primary logout_btn mt-2" disabled>{{ __('version') }}
                    {{ $setting->version ?? '1.0.0' }}</button>
                <button class="logout-button btn btn-danger mt-2"><i class="fas fa-sign-out-alt"></i></button>
            </div>
        </div>
    </aside>
</div>
