<div class="overflow-hidden space-bottom">
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
                <ul class="client-list-wrap style2">
                    @foreach ($brands->take(6) as $brand)
                        <li>
                            <a href="{{ $brand?->url }}">
                                <span class="link-effect">
                                    <span class="effect-1"><img src="{{ asset($brand?->image) }}"
                                            alt="{{ $brand?->name }}"></span>
                                    <span class="effect-1"><img src="{{ asset($brand?->image) }}"
                                            alt="{{ $brand?->name }}"></span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
