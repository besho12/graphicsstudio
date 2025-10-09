<div class="brands-area space-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="title-area text-center mb-50">
                    <h2 class="sec-title text-white">{{ $brandsSection?->translation?->content?->title ?? __('Trusted by Leading Brands') }}</h2>
            <p class="sec-text text-white opacity-75">{{ $brandsSection?->translation?->content?->sub_title ?? __('We are proud to work with some of the most innovative companies in the world') }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="brands-carousel-wrapper text-center">
                    <div class="brands-carousel d-flex justify-content-center align-items-center flex-wrap" id="brandsCarousel">
                        @forelse ($brands as $brand)
                            <div class="brand-item mx-3 mb-4">
                                <a href="{{ $brand?->url }}" target="_blank" class="brand-link d-inline-block">
                                    <div class="brand-logo">
                                        <img src="{{ asset($brand?->image) }}" alt="{{ $brand?->name }}" class="brand-img">
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center text-white">
                                    <p>{{ __('No brands available') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.brands-carousel-wrapper {
    padding: 20px 0;
}

.brands-carousel {
    gap: 30px;
    max-width: 100%;
    margin: 0 auto;
}

.brand-item {
    transition: transform 0.3s ease, opacity 0.3s ease;
    opacity: 0.8;
}

.brand-item:hover {
    transform: translateY(-5px);
    opacity: 1;
}

.brand-logo {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 80px;
    min-width: 120px;
}

.brand-logo:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.brand-img {
    max-width: 100px;
    max-height: 60px;
    width: auto;
    height: auto;
    object-fit: contain;
    filter: brightness(0) invert(1);
    transition: filter 0.3s ease;
}

.brand-logo:hover .brand-img {
    filter: brightness(0) invert(1) drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
}

@media (max-width: 768px) {
    .brands-carousel {
        gap: 20px;
    }
    
    .brand-logo {
        min-width: 100px;
        min-height: 70px;
        padding: 15px;
    }
    
    .brand-img {
        max-width: 80px;
        max-height: 50px;
    }
}
</style>
