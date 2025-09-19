<ul>
    @forelse (mainMenu() as $menu)
        @php
            $has_child = !empty($menu['child']);
            $is_home = $menu['link'] == '/';
        @endphp

        @if ($is_home && $setting?->show_all_homepage == 1)
            <li class="active menu-item-has-children">
                <a href="{{ route('home') }}" class="text-uppercase">
                    <span class="link-effect">
                        <span class="effect-1">{{ __('Home') }}</span>
                        <span class="effect-1">{{ __('Home') }}</span>
                    </span>
                </a>
                @php
                    $is_homepage = url()->current() == url('/');
                @endphp

                <ul class="sub-menu">
                    @foreach (App\Enums\ThemeList::themes() as $theme)
                        <li
                            class="{{ session()->get('demo_theme', DEFAULT_HOMEPAGE) == $theme?->name && $is_homepage ? 'active' : '' }}">
                            <a href="{{ route('change-theme', $theme?->name) }}">{{ $theme?->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li
                class="{{ $has_child ? 'menu-item-has-children' : '' }} {{ url()->current() == url($menu['link']) ? 'active' : '' }}">
                <a href="{{ $menu['link'] == '#' || empty($menu['link']) ? 'javascript:;' : url($menu['link']) }}"
                    class="text-uppercase" {{ $menu['open_new_tab'] ? 'target="_blank"' : '' }}>
                    <span class="link-effect">
                        <span class="effect-1">{{ $menu['label'] }}</span>
                        <span class="effect-1">{{ $menu['label'] }}</span>
                    </span>
                </a>

                {{-- @if ($has_child)
                    <ul class="sub-menu">
                        @foreach ($menu['child'] as $child)
                            <x-child-menu :menu="$child" />
                        @endforeach
                    </ul>
                @endif --}}
            </li>
        @endif
    @empty
        <li class="menu-item-has-children">
            <a href="{{ route('home') }}" class="text-uppercase">
                <span class="link-effect">
                    <span class="effect-1">{{ __('Home') }}</span>
                    <span class="effect-1">{{ __('Home') }}</span>
                </span>
            </a>
        </li>
    @endforelse



    {{-- language --}}
    <ul class="tg-header-top__social text-end header_language">
        @if (allLanguages()?->where('status', 1)->count() > 1)
            <li class="language-select-item select_item">
                <form id="setLanguageHeader2" action="{{ route('set-language') }}" method="get">
                    <select class="select_js" name="code">
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
            </li>
        @endif
    </ul>



</ul>