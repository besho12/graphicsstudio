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
                <ul class="client-list-wrap style3">
                    @forelse ($brands->take(8) as $brand)
                        <li>
                            <a href="{{ $brand?->url }}" target="_blank">
                                <span class="link-effect">
                                    <span class="effect-1"><img src="{{ asset($brand?->image) }}"
                                            alt="{{ $brand?->name }}"></span>
                                    <span class="effect-1"><img src="{{ asset($brand?->image) }}"
                                            alt="{{ $brand?->name }}"></span>
                                </span>
                            </a>
                        </li>
                    @empty
                        <li class="text-center">
                            <p>{{ __('No brands available') }}</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>