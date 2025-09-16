@if (Route::has('admin.award.index'))
    <li class="{{ isRoute('admin.award.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.award.index', ['code' => getSessionLanguage()]) }}">
            {{ __('Award Section') }}
        </a>
    </li>
@endif
