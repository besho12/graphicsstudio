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
                        <h1 class="hero-title">{!! processText($hero?->content?->title) !!}</h1>
                        <p class="hero-text">{!! processText($hero?->content?->sub_title) !!}</p>
                        <div class="btn-group fade_right">
                            <a href="{{ $hero?->global_content?->action_button_url }}"
                                class="btn">
                                <span class="link-effect text-uppercase">
                                    <span class="effect-1">{{ $hero?->content?->action_button_text }}</span>
                                    <span class="effect-1">{{ $hero?->content?->action_button_text }}</span>
                                </span>
                            </a>
                        </div>
                        {{-- <div class="hero-thumb-group img-custom-anim-right wow">
                            <img class="img1" src="{{ asset($hero?->global_content?->image_two) }}" alt="img">
                            <p>{{__('More than')}} {{ $hero?->content?->total_customers }} {{__('trusted customers')}}</p>
                        </div> --}}
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