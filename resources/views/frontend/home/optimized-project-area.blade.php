{{-- Optimized Projects Section --}}
<section class="projects-optimized" id="projects-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2 class="sec-title">{{ $project_section->title ?? 'Our Latest Projects' }}</h2>
                    <p class="sec-text">{{ $project_section->description ?? 'Discover our amazing portfolio of creative projects' }}</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                {{-- Optimized Project Grid (No Carousel) --}}
                <div class="project-grid" id="project-grid">
                    @if(isset($projects) && $projects->count() > 0)
                        @foreach($projects->take(4) as $project)
                            <div class="project-card-optimized" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="project-image-container">
                                    <a href="{{ route('single.portfolio', $project->slug) }}">
                                        <img 
                                            class="project-image-optimized" 
                                            src="{{ asset($project->image) }}" 
                                            alt="{{ $project->title }}"
                                            loading="lazy"
                                        >
                                        <div class="project-overlay">
                                            <div class="overlay-content">
                                                <span>View Project</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="project-content">
                                    <h3 class="project-title">{{ $project->title }}</h3>
                                    <p class="project-description">{{ Str::limit($project->description, 100) }}</p>
                                    <div class="project-meta-row">
                                        <div class="project-category">{{ $project->category->name ?? 'Design' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Loading state or empty state --}}
                        <div class="projects-loading">
                            <div class="loading-spinner"></div>
                            <p>Loading amazing projects...</p>
                        </div>
                    @endif
                </div>
                
                {{-- View All Projects Button --}}
                <div class="view-all-projects">
                    <a href="{{ route('portfolios') }}" class="view-all-btn">
                        <span>View All Projects</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Lazy Loading Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for lazy loading
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.getAttribute('data-src');
                
                if (src) {
                    img.src = src;
                    img.removeAttribute('data-src');
                    img.classList.remove('lazy-load');
                    observer.unobserve(img);
                }
            }
        });
    }, {
        rootMargin: '50px 0px',
        threshold: 0.1
    });

    // Observe all lazy load images
    document.querySelectorAll('.lazy-load').forEach(img => {
        imageObserver.observe(img);
    });

    // Simple AOS alternative for fade-up animation
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

<style>
/* Inline critical CSS for immediate rendering */
.project-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.project-card-optimized {
    background: linear-gradient(135deg, #0273df, #0056b3);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(2, 115, 223, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.project-image-container {
    height: 250px;
    overflow: hidden;
    background: #f0f0f0;
}

.project-image-optimized {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .project-grid {
        grid-template-columns: 1fr;
    }
}
</style>