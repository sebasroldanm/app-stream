<div class="card-owner-info">
    <div class="swiper mySwiperOwner">
        <div class="swiper-wrapper">
            @isset($primaryImage)
                <div class="swiper-slide">
                    <div class="content-image" style="background-image: url('{{ $primaryImage }}');">
                        <img src="{{ $primaryImage }}" alt="{{ $username }}">
                    </div>
                </div>
            @endisset
            @isset($secondaryImage)
                <div class="swiper-slide">
                    <div class="content-image" style="background-image: url('{{ $secondaryImage }}');">
                        <img src="{{ $secondaryImage }}" alt="{{ $username }}">
                    </div>
                </div>
            @endisset
            @isset($ternaryImage)
                <div class="swiper-slide">
                    <div class="content-image" style="background-image: url('{{ $ternaryImage }}');">
                        <img src="{{ $ternaryImage }}" alt="{{ $username }}">
                    </div>
                </div>
            @endisset
        </div>

        <div class="swiper-button-next-owner-info"></div>
        <div class="swiper-button-prev-owner-info"></div>
        @isset($viewersCount)
            <div class="position-absolute bottom-0 end-0 m-2 z-index-10">
                <span class="badge bg-dark text-white opacity-75">
                    {{ $viewersCount }} <i class="las la-eye"></i>
                </span>
            </div>
        @endisset
        @if (isset($isMobile) || isset($isFav))
            <div class="position-absolute top-0 start-0 m-1 z-index-10">
                <span class="badge bg-dark-50 text-white shadow-sm">
                    @if (isset($isMobile))
                        <i class="las {{ $isMobile ? 'la-mobile-alt' : 'la-laptop' }}"></i>
                    @endif
                    @if (isset($isFav) && $isFav)
                        <i class="las la-heart text-danger"></i>
                    @endif
                </span>
            </div>
        @endisset
        @if (isset($isNew) && $isNew)
            <div class="position-absolute top-0 end-0 m-1 z-index-10">
                <span class="badge bg-warning text-dark fw-bold">{{ __('owner/related.new') }}</span>
            </div>
        @endif
    </div>

    <div class="card-content text-center">
        <h6 class="text-truncate">{{ $username }}</h6>
    </div>
</div>
