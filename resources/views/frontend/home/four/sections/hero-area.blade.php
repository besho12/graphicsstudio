<div class="hero-wrapper hero-4 shape-mockup-wrap" id="hero">
    <div class="hero-4-thumb shape-mockup" data-left="0">
        @if($hero?->global_content?->image)
            <img class="w-100" src="{{ asset($hero->global_content->image) }}" alt="Hero Image" 
                 onerror="console.log('Hero image failed to load:', this.src); this.style.display='none';" 
                 onload="console.log('Hero image loaded successfully:', this.src); this.style.opacity='1';">
        @else
            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                No Hero Image Available
            </div>
        @endif
    </div>
    <div class="bg-theme">
        <div class="container">
            <div class="hero-style4">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="hero-title">Transform Your Vision Into Digital Reality</h1>
                        <p class="hero-text">We are a creative digital agency that helps businesses develop immersive and engaging user experiences that drive top-level growth and success.</p>
                        <div class="btn-group fade_right">
                            <a href="/portfolios" class="btn">
                                <span class="link-effect text-uppercase">
                                    <span class="effect-1">View Our Work</span>
                                    <span class="effect-1">View Our Work</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky-wrapper .main-menu li a, .sticky-wrapper .main-menu li .fas{
        color: #fff !important;
    }
</style>