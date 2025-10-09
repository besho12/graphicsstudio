<div class="brands-area space-bottom">
    <div class="container">
        @if($brandsSection?->translation?->content?->title || $brandsSection?->translation?->content?->sub_title)
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="title-area text-center mb-50">
                        @if($brandsSection?->translation?->content?->title)
                            <h2 class="sec-title">{{ $brandsSection->translation->content->title }}</h2>
                        @endif
                        @if($brandsSection?->translation?->content?->sub_title)
                            <p class="sec-text">{{ $brandsSection->translation->content->sub_title }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="brands-grid">
                    @forelse ($brands->take(6) as $brand)
                        <div class="brand-item">
                            <a href="{{ $brand?->url }}" target="_blank" class="brand-link">
                                <div class="brand-logo">
                                    <img src="{{ asset($brand?->image) }}" alt="{{ $brand?->name }}" class="brand-img">
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="text-center">
                            <p>{{ __('No brands available') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.brands-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 30px;
    align-items: center;
    justify-items: center;
}

.brand-item {
    transition: transform 0.3s ease;
}

.brand-item:hover {
    transform: translateY(-5px);
}

.brand-link {
    display: block;
    padding: 20px;
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.brand-link:hover {
    background: #e9ecef;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.brand-img {
    max-width: 120px;
    max-height: 60px;
    width: auto;
    height: auto;
    object-fit: contain;
    filter: grayscale(100%);
    transition: filter 0.3s ease;
}

.brand-link:hover .brand-img {
    filter: grayscale(0%);
}

@media (max-width: 768px) {
    .brands-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .brand-img {
        max-width: 100px;
        max-height: 50px;
    }
}
</style>