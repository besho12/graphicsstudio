{{-- Portfolio Section with Modern Design --}}
<section class="portfolio-modern-section" id="portfolio-section">
    <div class="portfolio-content-modern">
        {{-- Section Header --}}
        <div class="section-header-modern">
            <div class="section-badge">
                <i class="fas fa-briefcase"></i>
                <span>{{ __('Portfolio') }}</span>
            </div>
            <h2 class="section-title">{{ __('Discover Our Selected Projects') }}</h2>
            <p class="section-subtitle">{{ __('Discover our amazing portfolio of creative projects that showcase our expertise and innovation') }}</p>
        </div>

        {{-- Category Filter --}}
        <div class="portfolio-filter-modern">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">
                    <span>{{ __('All Projects') }}</span>
                </button>
                @if(isset($projects) && $projects->count() > 0)
                    @php
                        $categories = $projects->pluck('project_category')->unique()->filter();
                    @endphp
                    @foreach($categories as $category)
                        <button class="filter-btn" data-filter="{{ Str::slug($category) }}">
                            <span>{{ $category }}</span>
                        </button>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Portfolio Grid --}}
        <div class="portfolio-grid-modern">
            @if(isset($projects) && $projects->count() > 0)
                @foreach($projects->take(6) as $project)
                    <div class="portfolio-card-modern" data-category="{{ Str::slug($project->project_category) }}">
                        <div class="portfolio-image-wrapper">
                            <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="portfolio-image">
                            <div class="portfolio-image-overlay"></div>
                            <div class="portfolio-hover-content">
                                <div class="portfolio-category-tag">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $project->project_category }}</span>
                                </div>
                                <a href="{{ route('single.portfolio', $project->slug) }}" class="portfolio-action-btn">
                                    <span>{{ __('View Project') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <h3 class="portfolio-title">{{ $project->title }}</h3>
                            <p class="portfolio-description">{{ Str::limit($project->description ?? 'Explore this amazing project showcasing our creative expertise and innovative solutions.', 80) }}</p>
                            <div class="portfolio-meta">
                                <span class="portfolio-category-badge">{{ $project->project_category }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Empty state --}}
                <div class="portfolio-empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3>{{ __('No Projects Found') }}</h3>
                    <p>{{ __('We are working on amazing projects. Check back soon!') }}</p>
                </div>
            @endif
        </div>

        {{-- View All Projects Button --}}
        <div class="portfolio-view-all">
            <a href="{{ route('portfolios') }}" class="portfolio-view-all-btn">
                <span class="btn-text">{{ __('View All Projects') }}</span>
                <span class="btn-icon">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>
    </div>
</section>

{{-- Portfolio JavaScript for Category Filtering --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Filter Functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioCards = document.querySelectorAll('.portfolio-card-modern');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter portfolio cards
            portfolioCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    card.style.display = 'block';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Intersection Observer for animations
    const animateElements = document.querySelectorAll('[data-aos]');
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const delay = element.getAttribute('data-aos-delay') || 0;
                
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, delay);
                
                animationObserver.unobserve(element);
            }
        });
    }, {
        threshold: 0.1
    });

    // Initialize animations
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        animationObserver.observe(el);
    });
});
</script>

{{-- Portfolio Modern Styles --}}
<style>
/* Portfolio Section Base */
.portfolio-modern-section {
    background: #1d262e;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.portfolio-modern-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(147, 51, 234, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 60%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
    pointer-events: none;
}

.portfolio-content-modern {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Section Header */
.section-header-modern {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
    z-index: 2;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.section-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.section-badge:hover::before {
    left: 100%;
}

.section-title {
    font-size: 48px;
    font-weight: 700;
    background: linear-gradient(135deg, #ffffff, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 16px;
    line-height: 1.2;
}

.section-subtitle {
    font-size: 18px;
    color: #94a3b8;
    max-width: 600px;
    margin: 0 auto;
}

/* Category Filter */
.portfolio-filter-modern {
    margin-bottom: 50px;
    text-align: center;
}

.filter-buttons {
    display: inline-flex;
    gap: 12px;
    background: rgba(255, 255, 255, 0.05);
    padding: 8px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    flex-wrap: wrap;
    justify-content: center;
}

.filter-btn {
    background: transparent;
    border: none;
    color: #94a3b8;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.filter-btn.active,
.filter-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

/* Portfolio Grid */
.portfolio-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.portfolio-card-modern {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    overflow: hidden;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.4s ease;
    position: relative;
    group: hover;
}

.portfolio-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(59, 130, 246, 0.3);
}

.portfolio-image-wrapper {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.portfolio-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(147, 51, 234, 0.8));
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.portfolio-card-modern:hover .portfolio-image-overlay {
    opacity: 1;
}

.portfolio-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.portfolio-card-modern:hover .portfolio-image {
    transform: scale(1.1);
}

.portfolio-hover-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 2;
}

.portfolio-card-modern:hover .portfolio-hover-content {
    opacity: 1;
}

.portfolio-category-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
}

.portfolio-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: white;
    color: #1d262e;
    padding: 12px 24px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.portfolio-action-btn:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

/* Portfolio Content */
.portfolio-content {
    padding: 25px;
}

.portfolio-title {
    font-size: 20px;
    font-weight: 700;
    color: white;
    margin-bottom: 12px;
    line-height: 1.3;
}

.portfolio-description {
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 16px;
}

.portfolio-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.portfolio-category-badge {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
}

/* Empty State */
.portfolio-empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #94a3b8;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.portfolio-empty-state h3 {
    color: white;
    font-size: 24px;
    margin-bottom: 12px;
}

/* View All Button */
.portfolio-view-all {
    text-align: center;
}

.portfolio-view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 16px 32px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.portfolio-view-all-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.portfolio-view-all-btn:hover::before {
    left: 100%;
}

.portfolio-view-all-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
}

.btn-icon {
    transition: transform 0.3s ease;
}

.portfolio-view-all-btn:hover .btn-icon {
    transform: translateX(4px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .portfolio-content-modern {
        padding: 0 15px;
    }
    
    .section-title {
        font-size: 36px;
    }
    
    .portfolio-grid-modern {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .portfolio-modern-section {
        padding: 60px 0;
    }
    
    .section-header-modern {
        margin-bottom: 40px;
    }
    
    .section-title {
        font-size: 28px;
    }
    
    .section-subtitle {
        font-size: 16px;
    }
    
    .portfolio-grid-modern {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .filter-buttons {
        gap: 8px;
        padding: 12px;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 10px 20px;
    }
}
</style>