@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['portfolio_page']['seo_title'])
@section('meta_description', $seo_setting['portfolio_page']['seo_description'])

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :image="$setting?->portfolio_page_breadcrumb_image" :title="__('Portfolio')" />

    <!-- Modern Portfolio Section -->
    <section class="portfolio-modern-section py-5">
        <div class="container">
            {{-- Section Header --}}
            <div class="section-header text-center mb-5">
                <h2 class="section-title">{{ __('Discover Our Latest Projects') }}</h2>
            </div>

            {{-- Category Filter (Home-style pills with client-side filtering) --}}
            <div class="portfolio-filter-modern mb-5">
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <span>{{ __('All Projects') }}</span>
                    </button>
                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories as $category)
                            <button class="filter-btn" data-filter="{{ Str::slug($category) }}">
                                <span>{{ $category }}</span>
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Projects Grid --}}
            <div class="portfolio-grid-modern" id="portfolio-grid">
                @forelse ($projects as $project)
                    <div class="portfolio-card-modern" data-category="{{ Str::slug($project->project_category) }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="portfolio-image-wrapper">
                            <div class="portfolio-image-overlay"></div>
                            <img 
                                class="portfolio-image" 
                                src="{{ asset(!empty($project->thumbnail) ? $project->thumbnail : $project->image) }}" 
                                alt="{{ $project->title }}"
                                loading="lazy"
                            >
                            <div class="portfolio-hover-content">
                                <div class="portfolio-actions">
                                    <a href="{{ route('single.portfolio', $project->slug) }}" class="portfolio-action-btn">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ __('View Project') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-title-section">
                            <h3 class="portfolio-title">{{ $project->title }}</h3>
                            <span class="portfolio-category">{{ $project->project_category }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3 class="empty-state-title">{{ __('No Projects Found') }}</h3>
                        <p class="empty-state-description">{{ __('We haven\'t added any projects yet. Check back soon!') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($projects->hasPages())
                <div class="pagination-wrapper text-center mt-5">
                    {{ $projects->onEachSide(0)->links('frontend.pagination.custom') }}
                </div>
            @endif
        </div>

        {{-- Modern Portfolio Styles --}}
         <style>
             .portfolio-modern-section {
                 background: #1d262e;
                 min-height: 100vh;
                 padding: 80px 0;
             }

            .section-header {
                margin-bottom: 60px;
            }

            .section-title {
                 font-size: 3rem;
                 font-weight: 700;
                 color: #ffffff;
                 margin-bottom: 20px;
                 position: relative;
             }

             .section-title::after {
                 content: '';
                 position: absolute;
                 bottom: -10px;
                 left: 50%;
                 transform: translateX(-50%);
                 width: 80px;
                 height: 4px;
                 background: linear-gradient(45deg, #3498db, #2980b9);
                 border-radius: 2px;
             }

             .section-subtitle {
                 font-size: 1.2rem;
                 color: #b8c5d1;
                 max-width: 600px;
                 margin: 0 auto;
             }

            /* Portfolio Filter Styles (matched to home screen) */
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

            .portfolio-grid-modern {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 30px;
                margin-bottom: 60px;
            }

            .portfolio-card-modern {
                 background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
                 border-radius: 20px;
                 overflow: hidden;
                 box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                 transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
                 position: relative;
                 border: 1px solid rgba(255, 255, 255, 0.1);
                 height: 350px;
             }

             .portfolio-card-modern:hover {
                 transform: translateY(-10px);
                 box-shadow: 0 20px 60px rgba(52, 152, 219, 0.4);
             }

            .portfolio-image-wrapper {
                position: relative;
                width: 100%;
                height: 50%;
                overflow: hidden;
            }

            .portfolio-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s ease;
            }

            .portfolio-card-modern:hover .portfolio-image {
                transform: scale(1.1);
            }

            .portfolio-image-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(52, 152, 219, 0.9), rgba(41, 128, 185, 0.9));
                opacity: 0;
                transition: opacity 0.4s ease;
            }

            .portfolio-card-modern:hover .portfolio-image-overlay {
                opacity: 1;
            }

            .portfolio-hover-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
                opacity: 0;
                transition: all 0.4s ease;
                z-index: 10;
            }

            .portfolio-card-modern:hover .portfolio-hover-content {
                opacity: 1;
                transform: translate(-50%, -50%) translateY(-10px);
            }

            /* Category tag removed to match home screen */

            .portfolio-actions {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .portfolio-action-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                color: #ffffff;
                padding: 12px 24px;
                border-radius: 30px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }

            .portfolio-action-btn:hover {
                background: linear-gradient(135deg, #60a5fa, #3b82f6);
                color: #ffffff;
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
            }



            .empty-state {
                 grid-column: 1 / -1;
                 text-align: center;
                 padding: 80px 20px;
                 background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
                 border-radius: 20px;
                 box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                 border: 1px solid rgba(255, 255, 255, 0.1);
             }

             .empty-state-icon {
                 font-size: 4rem;
                 color: rgba(255, 255, 255, 0.6);
                 margin-bottom: 30px;
             }

             .empty-state-title {
                 font-size: 2rem;
                 color: #ffffff;
                 margin-bottom: 15px;
             }

             .empty-state-description {
                 color: rgba(255, 255, 255, 0.8);
                 font-size: 1.1rem;
                 max-width: 400px;
                 margin: 0 auto;
             }

            .pagination-wrapper {
                margin-top: 60px;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .portfolio-modern-section {
                    padding: 60px 0;
                }

                .section-title {
                    font-size: 2.2rem;
                }

                .filter-buttons {
                    gap: 10px;
                }

                .filter-btn {
                    padding: 10px 18px;
                    font-size: 0.9rem;
                }

                .portfolio-grid-modern {
                    grid-template-columns: 1fr;
                    gap: 20px;
                }

                .portfolio-card-modern {
                    margin: 0 15px;
                }

                .portfolio-image-wrapper {
                    height: 220px;
                }
            }

            @media (max-width: 480px) {
                .section-title {
                    font-size: 1.8rem;
                }

                .filter-buttons {
                    gap: 8px;
                }

                .filter-btn {
                    padding: 8px 16px;
                    font-size: 0.85rem;
                }

                .portfolio-content {
                    padding: 20px;
                }

                .portfolio-title {
                    font-size: 1.2rem;
                }
            }

            /* Portfolio Title Section */
            .portfolio-title-section {
                padding: 20px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                height: 50%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .portfolio-title {
                font-size: 18px;
                font-weight: 700;
                color: white;
                margin: 0 0 8px 0;
                line-height: 1.3;
            }

            .portfolio-category {
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
        </style>
        {{-- Client-side filtering (home screen behavior) --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
        </script>
    </section>

    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
