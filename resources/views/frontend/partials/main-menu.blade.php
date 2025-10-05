<ul class="fada-nav-list">
    @forelse (mainMenu() as $menu)
        @php
            $has_child = !empty($menu['child']);
            $is_home = $menu['link'] == '/';
        @endphp

        @if ($is_home && $setting?->show_all_homepage == 1)
            <li class="fada-nav-item {{ url()->current() == url('/') ? 'active' : '' }} {{ $has_child ? 'has-dropdown' : '' }}">
                <a href="{{ route('home') }}" class="fada-nav-link">
                    <span class="fada-nav-text">{{ __('Home') }}</span>
                    @if ($has_child)
                        <i class="fas fa-chevron-down fada-dropdown-icon"></i>
                    @endif
                </a>
                @php
                    $is_homepage = url()->current() == url('/');
                @endphp

                <ul class="fada-dropdown-menu">
                    @foreach (App\Enums\ThemeList::themes() as $theme)
                        <li class="fada-dropdown-item {{ session()->get('demo_theme', DEFAULT_HOMEPAGE) == $theme?->name && $is_homepage ? 'active' : '' }}">
                            <a href="{{ route('change-theme', $theme?->name) }}" class="fada-dropdown-link">
                                {{ $theme?->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="fada-nav-item {{ $has_child ? 'has-dropdown' : '' }} {{ url()->current() == url($menu['link']) ? 'active' : '' }}">
                <a href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}"
                    class="fada-nav-link" {{ $menu['open_new_tab'] ? 'target="_blank"' : '' }}>
                    <span class="fada-nav-text">{{ $menu['label'] }}</span>
                    @if ($has_child)
                        <i class="fas fa-chevron-down fada-dropdown-icon"></i>
                    @endif
                </a>

                @if ($has_child)
                    <ul class="fada-dropdown-menu">
                        @foreach ($menu['child'] as $child)
                            <li class="fada-dropdown-item">
                                <a href="{{ $child['link'] == '#' || empty($child['link']) ? 'javascript:;' : url($child['link']) }}" 
                                   class="fada-dropdown-link" {{ $child['open_new_tab'] ? 'target="_blank"' : '' }}>
                                    {{ $child['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @empty
        <li class="fada-nav-item">
            <a href="{{ route('home') }}" class="fada-nav-link">
                <span class="fada-nav-text">{{ __('Home') }}</span>
            </a>
        </li>
    @endforelse
</ul>