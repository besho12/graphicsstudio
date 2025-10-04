@if($chooseUsSection?->status)
<section class="why-area-1 bg-theme choose-us-simple">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="choose-us-content">
                    <h2 class="sec-title">
                        {!! clean(processText($chooseUsSection?->content?->title)) !!}
                    </h2>
                    <div class="choose-us-text">
                        {!! clean(processText($chooseUsSection?->content?->sub_title)) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="choose-us-image">
                    <img src="{{ asset($chooseUsSection?->global_content?->image) }}" 
                         alt="{{ clean(processText($chooseUsSection?->content?->title)) }}" 
                         class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@endif