@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['about_page']['seo_title'])
@section('meta_description', $seo_setting['about_page']['seo_description'])

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@push('css')
<style>
    .modern-about-page {
        background-color: #1d262e;
        min-height: 100vh;
        padding: 0;
    }
    
    .modern-about-hero {
        background: linear-gradient(135deg, #1d262e 0%, #2a3441 100%);
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }
    
    .modern-about-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(147, 197, 253, 0.08) 0%, transparent 50%);
    }
    
    .hero-content-modern {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }
    
    .hero-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        color: #60a5fa;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
    }
    
    .hero-title-modern {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #93c5fd 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.2;
    }
    
    .hero-description-modern {
        font-size: 1.2rem;
        color: #cbd5e1;
        max-width: 600px;
        margin: 0 auto 48px;
        line-height: 1.6;
    }
    
    .modern-stats-section {
        background-color: #1d262e;
        padding: 80px 0;
        position: relative;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    
    .stat-card-modern {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stat-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.3);
    }
    
    .stat-card-modern:hover::before {
        opacity: 1;
    }
    
    .stat-number-modern {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
        display: block;
    }
    
    .stat-title-modern {
        font-size: 1.3rem;
        font-weight: 600;
        color: white;
        margin-bottom: 12px;
    }
    
    .stat-description-modern {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .modern-content-section {
        background-color: #1d262e;
        padding: 80px 0;
    }
    
    .content-card-large {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 24px;
        padding: 60px;
        border: 1px solid rgba(59, 130, 246, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .content-card-large::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
    }
    
    .content-inner {
        position: relative;
        z-index: 2;
    }
    
    .section-title-modern {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #60a5fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .section-description-modern {
        font-size: 1.1rem;
        color: #cbd5e1;
        line-height: 1.7;
        margin-bottom: 40px;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-top: 40px;
    }
    
    .feature-item-modern {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 24px;
        background: rgba(59, 130, 246, 0.05);
        border-radius: 16px;
        border: 1px solid rgba(59, 130, 246, 0.1);
        transition: all 0.3s ease;
    }
    
    .feature-item-modern:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.2);
        transform: translateY(-2px);
    }
    
    .feature-icon-modern {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .feature-content-modern h4 {
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .feature-content-modern p {
        color: #94a3b8;
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0;
    }
    
    .modern-contact-section {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        padding: 100px 0;
        position: relative;
    }
    
    .contact-card-modern {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-radius: 24px;
        padding: 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .contact-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    }
    
    .contact-content-modern {
        position: relative;
        z-index: 2;
    }
    
    .contact-title-modern {
        font-size: 2.2rem;
        font-weight: 700;
        color: white;
        margin-bottom: 16px;
    }
    
    .contact-description-modern {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 32px;
        line-height: 1.6;
    }
    
    .contact-btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
        padding: 16px 32px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        border: 2px solid #0ea5e9;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    
    .contact-btn-modern:hover {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        border-color: #0284c7;
    }
    
    @media (max-width: 768px) {
        .hero-title-modern {
            font-size: 2.5rem;
        }
        
        .content-card-large {
            padding: 40px 30px;
        }
        
        .contact-card-modern {
            padding: 40px 30px;
        }
        
        .stat-card-modern {
            padding: 30px 20px;
        }
    }
</style>
@endpush

@section('contents')
    <div class="modern-about-page">
        <!-- Modern Hero Section -->
        <section class="modern-about-hero">
            <div class="container">
                <div class="hero-content-modern">
                    <div class="hero-badge-modern">
                        <i class="fas fa-users"></i>
                        {{__('About Our Studio')}}
                    </div>
                    <h1 class="hero-title-modern">{{__('Crafting Digital Excellence')}}</h1>
                    <p class="hero-description-modern">
                        {{__('We are a passionate team of designers and developers dedicated to creating exceptional digital experiences that drive results and inspire audiences.')}}
                    </p>
                </div>
            </div>
        </section>

        <!-- Modern Stats Section -->
        <section class="modern-stats-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title-modern">{{__('Our Journey in Numbers')}}</h2>
                    <p class="section-description-modern">{{__('These numbers represent our commitment to excellence and the trust our clients place in us.')}}</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card-modern">
                        <span class="stat-number-modern counter-number">{{$counterSection?->global_content?->year_experience_count ?? '5'}}+</span>
                        <h4 class="stat-title-modern">{{$counterSection?->content?->year_experience_title ?? __('Years Experience')}}</h4>
                        <p class="stat-description-modern">
                            {!! clean(processText($counterSection?->content?->year_experience_sub_title ?? __('Years of dedicated service in digital design and development'))) !!}
                        </p>
                    </div>
                    
                    <div class="stat-card-modern">
                        <span class="stat-number-modern counter-number">{{$counterSection?->global_content?->project_count ?? '150'}}+</span>
                        <h4 class="stat-title-modern">{{$counterSection?->content?->project_title ?? __('Projects Completed')}}</h4>
                        <p class="stat-description-modern">
                            {!! clean(processText($counterSection?->content?->project_sub_title ?? __('Successful projects delivered across various industries'))) !!}
                        </p>
                    </div>
                    
                    <div class="stat-card-modern">
                        <span class="stat-number-modern counter-number">{{$counterSection?->global_content?->customer_count ?? '100'}}+</span>
                        <h4 class="stat-title-modern">{{$counterSection?->content?->customer_title ?? __('Happy Clients')}}</h4>
                        <p class="stat-description-modern">
                            {!! clean(processText($counterSection?->content?->customer_sub_title ?? __('Satisfied clients who trust us with their digital presence'))) !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modern Content Section -->
        <section class="modern-content-section">
            <div class="container">
                <div class="content-card-large">
                    <div class="content-inner">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h2 class="section-title-modern">{{$chooseUsSection?->content?->title ?? __('Why Choose Our Studio')}}</h2>
                                <div class="section-description-modern">
                                    {!! clean(processText($chooseUsSection?->content?->sub_title ?? __('We combine creativity with technical expertise to deliver outstanding digital solutions that exceed expectations and drive business growth.'))) !!}
                                </div>
                                
                                <div class="features-grid">
                                    <div class="feature-item-modern">
                                        <div class="feature-icon-modern">
                                            <i class="fas fa-lightbulb"></i>
                                        </div>
                                        <div class="feature-content-modern">
                                            <h4>{{__('Creative Innovation')}}</h4>
                                            <p>{{__('Fresh ideas and innovative approaches to every project we undertake.')}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item-modern">
                                        <div class="feature-icon-modern">
                                            <i class="fas fa-rocket"></i>
                                        </div>
                                        <div class="feature-content-modern">
                                            <h4>{{__('Fast Delivery')}}</h4>
                                            <p>{{__('Quick turnaround times without compromising on quality or attention to detail.')}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item-modern">
                                        <div class="feature-icon-modern">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <div class="feature-content-modern">
                                            <h4>{{__('Quality Assurance')}}</h4>
                                            <p>{{__('Rigorous testing and quality control processes ensure perfect results.')}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item-modern">
                                        <div class="feature-icon-modern">
                                            <i class="fas fa-headset"></i>
                                        </div>
                                        <div class="feature-content-modern">
                                            <h4>{{__('24/7 Support')}}</h4>
                                            <p>{{__('Continuous support and maintenance to keep your projects running smoothly.')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="content-image-modern">
                                    @if($chooseUsSection?->global_content?->image)
                                        <img src="{{asset($chooseUsSection->global_content->image)}}" 
                                             alt="{{$chooseUsSection->content->title}}" 
                                             class="img-fluid rounded-3"
                                             style="border-radius: 20px; box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modern Contact Section -->
        <section class="modern-contact-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact-card-modern">
                            <div class="contact-content-modern">
                                <h2 class="contact-title-modern">{{__('Ready to Start Your Project?')}}</h2>
                                <p class="contact-description-modern">
                                    {{__('Let\'s discuss your ideas and create something amazing together. We\'re excited to hear about your vision and help bring it to life.')}}
                                </p>
                                <a href="{{ route('contact') }}" class="contact-btn-modern">
                                    <i class="fas fa-paper-plane"></i>
                                    {{__('Get In Touch')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
