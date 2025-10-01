<div class="hero-wrapper hero-1" id="hero">
    <div class="hero-bg-image">
        <img src="{{ asset($hero?->global_content?->image) }}" alt="Hero Background" class="hero-main-image">
    </div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.1s">{{$hero?->content?->title}}</h1>
                    <h1 class="hero-title-two wow img-custom-anim-left" data-wow-duration="1.7s" data-wow-delay="0.2s">{{$hero?->content?->title_two}}</h1>
                    <p class="hero-text wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.3s">{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                    <div class="btn-group fade_left">
                        <a href="{{$hero?->global_content?->action_button_url}}" class="btn btn-primary hero-btn wow img-custom-anim-left">
                            <span class="link-effect text-uppercase">
                                <span class="effect-1">{{$hero?->content?->action_button_text}}</span>
                                <span class="effect-1">{{$hero?->content?->action_button_text}}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>