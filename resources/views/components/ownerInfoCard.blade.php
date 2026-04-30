<div class="card-owner-info">
    <a href="{{ route('owner', $username) }}">
        <div class="swiper mySwiperOwner" data-settings="{{ json_encode($settings ?? []) }}">
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
            @if (isset($status) && $status != 'public')
                <div class="position-absolute top-0 start-0 z-index-10 w-100 h-100 status-live-badge">
                    @switch($status)
                        @case("p2p")
                            <span class="badge bg-warning text-dark p-1"><i class="ri-eye-off-fill"></i><p class="mb-0 mt-1">{{ __('components/ownerInfoCard.p2p') }}</p></span>
                            @break
                        @case("private")
                            <span class="badge bg-danger text-dark mt-1 pt-1"><i class="ri-lock-fill"></i><p class="mb-0">{{ __('components/ownerInfoCard.private') }}</p></span>
                            @break
                        @case("groupShow")
                            <span class="badge bg-success text-white"><i class="ri-group-line"></i></span>
                            @break
                        @case("blocked")
                            <span class="badge bg-danger text-dark mt-1 pt-1"><i class="ri-eye-off-fill"></i><p class="mb-0">{{ __('components/ownerInfoCard.blocked') }}</p></span>
                            @break
                        @case("inactive")
                            <span class="badge bg-dark text-white mt-1 pt-1"><i class="ri-eye-off-fill"></i><p class="mb-0">{{ __('components/ownerInfoCard.inactive') }}</p></span>
                            @break
                        @default
                            {{ $status }}
                    @endswitch
                </div>
            @endif
            @if (isset($primaryImage) && isset($secondaryImage))
                <div class="swiper-button-next-owner-info"></div>
                <div class="swiper-button-prev-owner-info"></div>
            @endif
            @if (isset($viewersCount) && $viewersCount)
                <div class="position-absolute bottom-0 end-0 m-1 z-index-10">
                    <span class="badge bg-dark text-white opacity-75">
                        {{ number_format($viewersCount, 0, '', '.') }} <i class="las la-eye"></i>
                    </span>
                </div>
            @endif
            @if (isset($isMobile) || isset($isFav) || isset($country))
                <div class="position-absolute top-0 start-0 m-1 z-index-10">
                    <span class="badge bg-dark-50 text-white shadow-sm">
                        @if (isset($isMobile))
                            <i class="las {{ $isMobile ? 'la-mobile-alt' : 'la-laptop' }}"></i>
                        @endif
                        @if (isset($isFav) && $isFav)
                            <i class="las la-heart text-danger"></i>
                        @endif
                        @if (isset($country))
                            {!! $country !!}
                        @endif
                    </span>
                </div>
            @endif
            @if (isset($isGames) || isset($gender))
                <div class="position-absolute bottom-0 start-0 m-1 z-index-10">
                    <span class="badge bg-dark-50 text-white shadow-sm">
                        @if (isset($isGames) && $isGames)
                            <i class="las la-dice"></i>
                        @endif
                        @if (isset($gender))
                            @switch($gender)
                                @case("group")
                                    <i class="las la-users"></i>
                                    @break
                                @case("male")
                                    <i class="las la-male"></i>
                                    @break
                                @case("female")
                                    <i class="las la-female"></i>
                                    @break
                                @default
                                    {{-- {{ $gender }} --}}
                            @endswitch
                        @endif
                    </span>
                </div>
            @endif
            @if (isset($isNew) || isset($isLive) || isset($lastLive))
                <div class="position-absolute top-0 end-0 m-1 z-index-10">
                    @if (isset($isNew) && $isNew)
                        <span class="badge bg-warning text-dark fw-bold">{{ __('owner/related.new') }}</span>
                    @endif
                    @if (isset($isLive) && $isLive)
                        <span class="badge bg-danger text-white"><span class="text-white">{{ __('components/ownerInfoCard.live') }} </span></span>
                    @endif
                    @if (isset($lastLive) && !$isLive)
                        <span class="badge bg-dark opacity-50 text-white shadow-sm"><i class="lar la-clock"></i> {{ $lastLive }}</span>
                    @endif
                </div>
            @endif
        </div>

        <div class="card-content text-center">
            <h6 class="text-truncate">{{ $username }}</h6>
        </div>
    </a>
</div>
