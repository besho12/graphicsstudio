<div class="brands-area space-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="title-area text-center mb-50">
                    <h2 class="sec-title text-white">{{ __('Trusted by Leading Brands') }}</h2>
                    <p class="sec-text text-white opacity-75">{{ __('We are proud to work with some of the most innovative companies in the world') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="brands-carousel-wrapper">
                    <div class="brands-carousel" id="brandsCarousel">
                        @forelse ($brands as $brand)
                            <div class="brand-item">
                                <a href="{{ $brand?->url }}" target="_blank" class="brand-link">
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
                        
                        {{-- Duplicate brands for seamless infinite scroll --}}
                        @if($brands->count() > 0)
                            @foreach ($brands as $brand)
                                <div class="brand-item">
                                    <a href="{{ $brand?->url }}" target="_blank" class="brand-link">
                                        <div class="brand-logo">
                                            <img src="{{ asset($brand?->image) }}" alt="{{ $brand?->name }}" class="brand-img">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
