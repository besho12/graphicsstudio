<div>
    <div class="contact-map wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.2s"
        data-left="0" data-top="-100px" data-bottom="140px">
        <iframe src="{{ $contactSection?->map }}" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="container">
        <div class="row align-items-center justify-content-end">
            <div class="col-lg-6">
                <div class="contact-form-wrap">
                    <div class="title-area mb-30">
                        <h2 class="sec-title">{{ __('Have Any Project on Your Mind?') }}</h2>
                            <p>{{ __("Great! We're excited to hear from you and let's start something") }}</p>
                    </div>
                    <form action="{{ route('send-contact-message') }}" id="contact-form" class="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control style-border" name="name"
                                        placeholder="{{ __('Full name') }}*" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control style-border" name="email"
                                        placeholder="{{ __('Email address') }}*" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form-control style-border" name="website"
                                        placeholder="{{ __('Website link') }}" value="{{ old('website') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form-control style-border" name="subject"
                                        placeholder="{{ __('Subject') }}*" value="{{ old('subject') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="message" placeholder="{{ __('How Can We Help You') }}*" class="form-control style-border" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        @if ($setting?->recaptcha_status == 'active')
                            <div class="form-group mb-0 col-12">
                                <div class="g-recaptcha" data-sitekey="{{ $setting?->recaptcha_site_key }}"></div>
                            </div>
                        @endif
                        <div class="form-btn col-12">
                            <button type="submit" class="btn mt-20">
                                <span class="link-effect text-uppercase">
                                    <span class="effect-1">{{ __('Send message') }}</span>
                                    <span class="effect-1">{{ __('Send message') }}</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>