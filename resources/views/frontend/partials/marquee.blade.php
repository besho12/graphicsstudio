@if (marquees()->count())
<div class="modern-marquee">
    <div class="marquee-content">
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee->title }}</span>
                        <i class="fas fa-star-of-life marquee-separator"></i>
            </div>
        @endforeach
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
                        <i class="fas fa-star-of-life marquee-separator"></i>
            </div>
        @endforeach
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
                        <i class="fas fa-star-of-life marquee-separator"></i>
            </div>
        @endforeach
        @foreach (marquees() as $marquee)
            <div class="marquee-item">
                <span class="text">{{ $marquee?->title }}</span>
                        <i class="fas fa-star-of-life marquee-separator"></i>
            </div>
        @endforeach
    </div>
</div>
@endif