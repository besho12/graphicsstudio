@if (marquees()->count())
<div class="modern-marquee">
    <div class="marquee-content">
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
            </div>
        @endforeach
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
            </div>
        @endforeach
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
            </div>
        @endforeach
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
            </div>
        @endforeach
    </div>
</div>
@endif