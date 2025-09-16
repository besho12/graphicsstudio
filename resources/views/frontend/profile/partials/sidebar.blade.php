<div class="col-lg-4 col-xl-3 ">
    <div class="wsus__dashboard_sidebar">
        <div class="wsus__dashboard_sidebar_top">
            <div class="wsus__dashboard_profile_img">
                <img id="profile_img"
                    src="{{ !empty(userAuth()?->image) ? asset(userAuth()?->image) : asset($setting?->default_avatar) }}"
                    alt="{{ userAuth()?->name }}" class="img-fluid w-100 h-100">
                <label for="profile_photo"><i class="fas fa-camera fa-2x text-white"></i></label>
                <form action="{{ route('user.update.profile-image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="profile_photo" name="image" hidden>
                    <button id="update_profile_image" class="btn style2 py-1 px-2 my-1 d-none">
                        <span class="link-effect">
                            <span class="effect-1">{{ __('Update') }}</span>
                            <span class="effect-1">{{ __('Update') }}</span>
                        </span>
                    </button>
                </form>
            </div>
            <h5>{{ userAuth()?->name }}</h5>
            <p>{{ userAuth()?->address }}</p>
        </div>
        <ul class="wsus__deshboard_menu">
            <li>
                <a class="{{ isRoute(['user.dashboard', 'user.profile.edit'], 'active') }}"
                    href="{{ route('dashboard') }}"><i class="fas fa-user-tie"></i>
                    {{ __('Profile') }}</a>
            </li>
            @if ($setting?->is_shop)
                <li>
                    <a class="{{ isRoute(['user.order', 'user.order.show'], 'active') }}"
                        href="{{ route('user.order') }}"><i class="fas fa-cart-plus"></i>
                        {{ __('Order') }}</a>
                </li>
                <li>
                    <a class="{{ isRoute(['user.digital.products'], 'active') }}"
                        href="{{ route('user.digital.products') }}"><i class="fas fa-download"></i>
                        {{ __('Digital Product') }}</a>
                </li>
                <li>
                    <a class="{{ isRoute('user.wishlist.index', 'active') }}"
                        href="{{ route('user.wishlist.index') }}"><i class="fas fa-heart"></i>
                        {{ __('Wishlist') }}</a>
                </li>
                <li>
                    <a class="{{ isRoute('user.customers-review.index', 'active') }}"
                        href="{{ route('user.customers-review.index') }}"><i class="fas fa-star"></i>
                        {{ __('Reviews') }}</a>
                </li>
                <li>
                    <a class="{{ isRoute(['user.billing.index'], 'active') }}"
                        href="{{ route('user.billing.index') }}"><i class="fas fa-map"></i>
                        {{ __('Billing Addresses') }}</a>
                </li>
            @endif
            <li>
                <a href="{{ route('user.pricing') }}" class="{{ isRoute('user.pricing', 'active') }}"><i
                        class="fas fa-dollar-sign"></i></i>
                    {{ __('Pricing Plan') }}</a>
            </li>
            <li>
                <a class="{{ isRoute('user.change-password', 'active') }}"
                    href="{{ route('user.change-password') }}"><i class="fas fa-key"></i>
                    {{ __('Change Password') }}</a>

            </li>
            <li>
                <a role="button" class="logout-button"><i class="fas fa-unlock-alt"></i> {{ __('Log Out') }}
                    <form action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </li>
        </ul>
    </div>
</div>
