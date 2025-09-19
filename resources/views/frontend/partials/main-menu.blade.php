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

<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script>
    (function ($) {
        $(document).ready(function () {
            console.log('here0');
            setupChangeHandler("#setLanguageHeader2");
            $("form").attr("autocomplete", "off");
        });
        function setupChangeHandler(formSelector) {
            var $form = $(formSelector);
            var $select = $form.find("select");
            var previousValue = $select.val();
            console.log('here1');

            $('.nice-select.select_js').on("change", function (e) {
                console.log('here2');
                
                var currentValue = $(this).val();
                if (currentValue !== previousValue) $form.trigger("submit");
                previousValue = currentValue;
            });
        }
    })(jQuery);

//find .option.sected and get its data-value
                //then find select tag with class .select_js then unselect all options and make the option with value coming from the prev data-value as selected
</script>
