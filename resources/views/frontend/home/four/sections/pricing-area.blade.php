<div class="space home_4_pricing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-7 col-xl-6 col-lg-8">
                <div class="title-area text-center">
                    <h2 class="sec-title">{{__('Best Pricing Plan')}}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @forelse ($plans as $plan)
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card bg-smoke">
                        <h4 class="pricing-card_title">{{ $plan?->plan_name }}</h4>
                        <div class="price-card-wrap">
                            <h4 class="pricing-card_price"><span
                                    class="currency">{{ currency($plan?->plan_price) }}</span><span
                                    class="duration">/{{ $plan?->expiration_date }}</span>
                            </h4>
                        </div>
                        <p>{{ $plan?->short_description }}</p>
                        <div class="checklist">
                            {!! clean($plan?->description) !!}
                        </div>
                        @if ($plan?->button_text)
                            <a href="{{ $plan?->button_url }}" class="btn">
                                <span class="link-effect text-uppercase">
                                    <span class="effect-1">{{ $plan?->button_text }}</span>
                                    <span class="effect-1">{{ $plan?->button_text }}</span>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <tr>
                    <x-data-not-found />
                </tr>
            @endforelse
        </div>
    </div>
</div>
