@if($chooseUsSection?->status)
{{-- Modern Choose Us Section --}}
<div class="modern-choose-us-section space">
    <div class="container">
        <!-- Main Content -->
        <div class="row align-items-stretch">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="choose-us-content-modern">
                    <div class="content-card">
                        <div class="card-icon-wrapper">
                            <div class="icon-bg-effect"></div>
                            <i class="fas fa-star card-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="feature-title">{{ clean(processText($chooseUsSection?->translation?->content?->feature_title_1 ?? __('Premium Quality'))) }}</h3>
                            <p class="feature-description">{{ clean(processText($chooseUsSection?->translation?->content?->feature_description_1 ?? __('We deliver exceptional quality in every project, ensuring your vision comes to life with precision and excellence.'))) }}</p>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-icon-wrapper">
                            <div class="icon-bg-effect"></div>
                            <i class="fas fa-clock card-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="feature-title">{{ clean(processText($chooseUsSection?->translation?->content?->feature_title_2 ?? __('Fast Delivery'))) }}</h3>
                            <p class="feature-description">{{ clean(processText($chooseUsSection?->translation?->content?->feature_description_2 ?? __('Quick turnaround times without compromising quality. We understand the importance of meeting deadlines.'))) }}</p>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-icon-wrapper">
                            <div class="icon-bg-effect"></div>
                            <i class="fas fa-users card-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="feature-title">{{ clean(processText($chooseUsSection?->translation?->content?->feature_title_3 ?? __('Expert Team'))) }}</h3>
                            <p class="feature-description">{{ clean(processText($chooseUsSection?->translation?->content?->feature_description_3 ?? __('Our experienced professionals bring creativity and technical expertise to every project we undertake.'))) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="choose-us-image-modern">
                    <div class="image-wrapper">
                        <div class="image-overlay"></div>
                        <img src="{{asset($chooseUsSection?->global_content?->image)}}" alt="{{clean(processText($chooseUsSection?->translation?->content?->title))}}" class="img-fluid modern-image">
                    </div>
                </div>
                
                <!-- Content container -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="choose-us-text-container">
                            {!! clean(processText($chooseUsSection?->translation?->content?->sub_title)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif