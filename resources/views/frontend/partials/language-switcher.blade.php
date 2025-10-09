@if (Module::isEnabled('Language') && Route::has('set-language') && allLanguages()?->where('status', 1)->count() > 1)
    <div class="language-switcher {{ $class ?? '' }}">
        <div class="language-dropdown">
            <button class="language-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="current-language">
                    <span class="language-icon">
                        <i class="fas fa-globe"></i>
                    </span>
                    <span class="language-text">
                        {{ allLanguages()?->firstWhere('code', getSessionLanguage())?->name ?? __('English') }}
                    </span>
                    <span class="dropdown-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>
            </button>
            
            <ul class="language-menu dropdown-menu">
                @forelse (allLanguages()?->where('status', 1) as $language)
                    <li class="language-item {{ getSessionLanguage() == $language->code ? 'active' : '' }}">
                        <a href="{{ getSessionLanguage() == $language->code ? 'javascript:;' : route('set-language', ['code' => $language->code]) }}" 
                           class="language-link">
                            <span class="language-flag">
                                @switch($language->code)
                                    @case('en')
                                        🇺🇸
                                        @break
                                    @case('ar')
                                        🇸🇦
                                        @break
                                    @case('hi')
                                        🇮🇳
                                        @break
                                    @case('es')
                                        🇪🇸
                                        @break
                                    @case('fr')
                                        🇫🇷
                                        @break
                                    @case('de')
                                        🇩🇪
                                        @break
                                    @case('it')
                                        🇮🇹
                                        @break
                                    @case('pt')
                                        🇵🇹
                                        @break
                                    @case('ru')
                                        🇷🇺
                                        @break
                                    @case('ja')
                                        🇯🇵
                                        @break
                                    @case('ko')
                                        🇰🇷
                                        @break
                                    @case('zh')
                                        🇨🇳
                                        @break
                                    @default
                                        🌐
                                @endswitch
                            </span>
                            <span class="language-name">{{ $language->name }}</span>
                            @if(getSessionLanguage() == $language->code)
                                <span class="check-icon">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </a>
                    </li>
                @empty
                    <li class="language-item active">
                        <a href="javascript:;" class="language-link">
                            <span class="language-flag">🇺🇸</span>
                            <span class="language-name">{{ __('English') }}</span>
                            <span class="check-icon">
                                <i class="fas fa-check"></i>
                            </span>
                        </a>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endif