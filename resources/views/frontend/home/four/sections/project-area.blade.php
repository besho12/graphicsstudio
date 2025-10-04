<div class="project-area-4 space-bottom overflow-hidden">
    <div class="container">        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="title-area text-center mb-5">
                    <h2 class="sec-title text-white mb-3">{{ __('Discover Our Selected Projects') }}</h2>
                    <p class="text-white-75">Explore our portfolio of innovative solutions and creative designs that have helped our clients achieve their goals.</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 gx-4">
            @foreach ($projects->take(6) as $index => $project)
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card-modern">
                        <a href="{{ route('single.portfolio', $project?->slug) }}" class="portfolio-wrap style-feature">
                            <div class="portfolio-thumb">
                                <img src="{{ asset($project?->image) }}" alt="{{ $project?->title }}">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-icon">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="portfolio-details">
                                <h3 class="portfolio-title">{{ $project?->title }}</h3>
                                <div class="portfolio-meta-row">
                                    <span class="category-badge">{{ $project?->project_category }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="btn-wrap mt-60 text-center">
            <a href="{{ route('portfolios') }}" class="btn btn-modern">
                <span class="btn-text">{{ __('View All Projects') }}</span>
                <span class="btn-icon">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
