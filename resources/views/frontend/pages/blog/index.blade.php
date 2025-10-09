@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['blog_page']['seo_title'])
@section('meta_description', $seo_setting['blog_page']['seo_description'])

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :image="$setting?->blog_page_breadcrumb_image" :title="__('Blog')" />

    <!-- Main Area -->
    <section class="blog__area space">
        <div class="container">
            <div class="blog__inner-wrap">
                <div class="row">
                    <div class="col-70">
                        <div class="blog-post-wrap">
                            <div class="row gy-50 gutter-24">
                                @include('frontend.pages.blog.layouts.' . ($setting?->blog_layout ?? 'standard'))
                            </div>
                            @if ($blogs->hasPages())
                                {{ $blogs->onEachSide(0)->links('frontend.pagination.custom') }}
                            @endif
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
                                        <div class="sidebar__post-item">
                                            <div class="sidebar__post-thumb">
                                                <a href="{{ route('single.blog', $popular?->slug) }}"><img
                                                        src="{{ asset($popular?->image) }}" alt="{{ $popular?->title }}"></a>
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
