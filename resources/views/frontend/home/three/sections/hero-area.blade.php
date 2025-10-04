<div class="hero-wrapper hero-3" id="hero">
    <div class="container">
        <div class="hero-style3">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="hero-title">{{$hero?->content?->title}}</h1>
                    <div class="hero-3-thumb">
                        <img class="w-100" src="{{ asset($hero?->global_content?->image) }}" alt="img">
                    </div>
                    <h1 class="hero-title text-end">{{$hero?->content?->title_two}}</h1>
                </div>
                <div class="col-lg-6 offset-lg-6">
                    <p class="hero-text">{!! clean(processText($hero?->content?->sub_title)) !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>