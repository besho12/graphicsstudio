@extends('frontend.layouts.master')

@section('meta_title', $blog?->title . ' || ' . $setting->app_name)
@section('meta_description', $blog?->seo_description)

@push('custom_meta')
    <meta property="og:title" content="{{ $blog?->seo_title }}" />
    <meta property="og:description" content="{{ $blog?->seo_description }}" />
    <meta property="og:image" content="{{ asset($blog?->image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- breadcrumb-area -->
    <x-breadcrumb-two :title="$blog?->title" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => route('blogs'), 'text' => __('Blog')]]" />

    <!-- Main Area -->
    <section class="blog__details-area space">
        <div class="container">
            <div class="blog__inner-wrap">
                <div class="row">
                    <div class="col-70">
                        <div class="blog__details-wrap">
                            <div class="blog__details-thumb">
                                <img src="{{ asset($blog?->image) }}" alt="{{ $blog?->title }}">
                            </div>
                            <div class="blog__details-content details-text">
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li>{{ formattedDate($blog?->created_at) }}</li>
                                        <li>
                                            <a
                                                href="{{ route('blogs', ['category' => $blog?->category?->slug]) }}">{{ $blog?->category?->title }}</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">{{ __('by') }} {{ $blog?->admin?->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <h2 class="title">{{ $blog?->title }}</h2>
                                <div class="blog-post-description">
                                    {!! clean(replaceImageSources($blog?->description)) !!}
                                </div>

                                <div class="blog__details-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <div class="post-tags">
                                                <ul class="list-wrap">
                                                    {!! $tagString !!}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="post-share">
                                                <h5 class="title">{{ __('Share') }}:</h5>
                                                <div class="social-btn style3 justify-content-md-end">
                                                    <a class="share-social" href="{{ route('single.blog', $blog?->slug) }}"
                                                        data-platform="facebook">
                                                        <span class="link-effect">
                                                            <span class="effect-1"><i class="fab fa-facebook"></i></span>
                                                            <span class="effect-1"><i class="fab fa-facebook"></i></span>
                                                        </span>
                                                    </a>
                                                    <a class="share-social" href="{{ route('single.blog', $blog?->slug) }}"
                                                        data-platform="linkedin">
                                                        <span class="link-effect">
                                                            <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                                                            <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                                                        </span>
                                                    </a>
                                                    <a class="share-social" href="{{ route('single.blog', $blog?->slug) }}"
                                                        data-platform="twitter">
                                                        <span class="link-effect">
                                                            <span class="effect-1"><i class="fab fa-twitter"></i></span>
                                                            <span class="effect-1"><i class="fab fa-twitter"></i></span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="inner__page-nav mt-20 mb-n1">
                                    <a href="{{ $prevPost ? route('single.blog', $prevPost?->slug) : 'javascript:;' }}"
                                        class="nav-btn {{ $prevPost ? '' : 'disabled' }}">
                                        <i class="fa fa-arrow-left"></i> <span><span class="link-effect">
                                                <span class="effect-1">{{ __('Previous Post') }}</span>
                                                <span class="effect-1">{{ __('Previous Post') }}</span>
                                            </span></span>
                                    </a>
                                    <a href="{{ $nextPost ? route('single.blog', $nextPost?->slug) : 'javascript:;' }}"
                                        class="nav-btn {{ $nextPost ? '' : 'disabled' }}"><span><span class="link-effect">
                                                <span class="effect-1">{{ __('Next Post') }}</span>
                                                <span class="effect-1">{{ __('Next Post') }}</span>
                                            </span></span>
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="comments-wrap space-top">
                                <h3 class="comments-wrap-title">({{ $blog?->comments_count }}) {{ __('Comments') }}</h3>
                                <div class="latest-comments">
                                    <ul class="list-wrap">
                                        @foreach ($comments as $comment)
                                            <x-blog-comment :comment="$comment" :slug="$blog->slug" />
                                        @endforeach
                                        @if ($comments->hasPages())
                                            {{ $comments->onEachSide(0)->links('frontend.pagination.custom') }}
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @auth('web')
                                <div class="comment-respond">
                                    <h3 class="comment-reply-title">{{ __('Leave a Reply') }}</h3>
                                    <form action="{{ route('blog.comment.store', $blog->slug) }}" method="post"
                                        class="comment-form">
                                        <p class="comment-notes">
                                            {{ __('Share your thoughts on this post! Your insights and feedback are welcome.') }}
                                        </p>
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <textarea name="comment" placeholder="{{ __('Write your comment') }}*" class="form-control style-border style2"></textarea>
                                                </div>
                                            </div>
                                            @if ($setting->recaptcha_status == 'active')
                                                <div class="col-lg-12">
                                                    <div class="g-recaptcha" data-sitekey="{{ $setting->recaptcha_site_key }}">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-btn col-12">
                                            <button type="submit" class="btn mt-25">
                                                <span class="link-effect text-uppercase">
                                                    <span class="effect-1">{{ __('Post Comment') }}</span>
                                                    <span class="effect-1">{{ __('Post Comment') }}</span>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="col-30">
                        <aside class="blog__sidebar">
                            {{-- Search widget removed --}}
                            <div class="sidebar__widget">
                                <h4 class="sidebar__widget-title">{{ __('Categories') }}</h4>
                                <div class="sidebar__cat-list">
                                    <ul class="list-wrap">
                                        @foreach ($categories as $category)
                                            <li><a href="{{ route('blogs', ['category' => $category?->slug]) }}">{{ $category?->translation?->title }}
                                                    ({{ $category->posts_count ?? 0 }})
                                                </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar__widget">
                                <h4 class="sidebar__widget-title">{{ __('Popular Posts') }}</h4>
                                <div class="sidebar__post-list">
                                    @foreach ($popular_blogs as $popular)
                                        @continue($blog?->slug == $popular?->slug)
                                        <div class="sidebar__post-item">
                                            <div class="sidebar__post-thumb">
                                                <a href="{{ route('single.blog', $popular?->slug) }}"><img
                                                        src="{{ asset($popular?->image) }}"
                                                        alt="{{ $popular?->title }}"></a>
                                            </div>
                                            <div class="sidebar__post-content">
                                                <h5 class="title"><a
                                                        href="{{ route('single.blog', $popular?->slug) }}">{{ Str::limit($popular?->title, 30, '...') }}</a>
                                                </h5>
                                                <span class="date"><i
                                                        class="flaticon-time"></i>{{ formattedDate($popular?->created_at) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if ($topTags)
                                <div class="sidebar__widget">
                                    <h4 class="sidebar__widget-title">{{ __('Tags') }}</h4>
                                    <div class="sidebar__tag-list">
                                        <ul class="list-wrap">
                                            @foreach ($topTags as $key => $tag)
                                                <li class="text-capitalize"><a
                                                        href="{{ route('blogs', ['tag' => $key]) }}">{{ $key }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
