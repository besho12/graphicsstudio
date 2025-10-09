<li class="{{ isRoute('admin.hero-section.index', 'active') }}">
    <a class="nav-link" href="{{ route('admin.hero-section.index', ['code' => 'en']) }}">
        {{ __('Hero Section') }}
    </a>
</li>
<li class="{{ isRoute('admin.service-section.index', 'active') }}">
    <a class="nav-link" href="{{ route('admin.service-section.index', ['code' => 'en']) }}">
        {{ __('Service Section') }}
    </a>
</li>
<li class="{{ isRoute('admin.project-section.index', 'active') }}">
    <a class="nav-link" href="{{ route('admin.project-section.index', ['code' => 'en']) }}">
        {{ __('Project Section') }}
    </a>
</li>