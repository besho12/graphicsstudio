<ul>
    @if ($setting?->show_all_homepage == 1)
        @php
            $has_child = true;
            $is_homepage = url()->current() == url('/');
        @endphp

        <li class="menu-item-has-children {{ url()->current() == url('/') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="text-uppercase">{{ __('Home') }}</a>

            @if ($has_child)
                <ul class="sub-menu">
                    @foreach (App\Enums\ThemeList::themes() as $theme)
                        <li class="{{ session()->get('demo_theme', DEFAULT_HOMEPAGE) == $theme?->name && $is_homepage ? 'active' : '' }}">
                            <a href="{{ route('change-theme', $theme?->name) }}">
                                {{ $theme?->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endif

    @forelse (mainMenu() as $menu)
        @php
            $has_child = !empty($menu['child']);
        @endphp
        <li class="{{ $has_child ? 'menu-item-has-children' : '' }} {{ url()->current() == url($menu['link']) ? 'active' : '' }}">
            <a href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}"
                class="text-uppercase" {{ $menu['open_new_tab'] ? 'target="_blank"' : '' }}>
                {{ $menu['label'] }}
            </a>

            @if ($has_child)
                <ul class="sub-menu">
                    @foreach ($menu['child'] as $child)
                        <li>
                            <a href="{{ $child['link'] == '#' || empty($child['link']) ? 'javascript:;' : url($child['link']) }}"
                                {{ $child['open_new_tab'] ? 'target="_blank"' : '' }}>
                                {{ $child['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @empty
        <li>
            <a href="{{ route('home') }}" class="text-uppercase">{{ __('Home') }}</a>
        </li>
    @endforelse
</ul>