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

            @if (isset($primaryImage) && isset($secondaryImage))
                <div class="swiper-button-next-owner-info"></div>
                <div class="swiper-button-prev-owner-info"></div>
            @endif
            @isset($viewersCount)
                <div class="position-absolute bottom-0 end-0 m-1 z-index-10">
                    <span class="badge bg-dark text-white opacity-75">
                        {{ number_format($viewersCount, 0, '', '.') }} <i class="las la-eye"></i>
                    </span>
                </div>
            @endisset
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
            @endisset
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
            @if (isset($isNew) || isset($status))
                <div class="position-absolute top-0 end-0 m-1 z-index-10">
                    @if (isset($isNew) && $isNew)
                        <span class="badge bg-warning text-dark fw-bold">{{ __('owner/related.new') }}</span>
                    @endif
                    @if (isset($status))
                        @switch($status)
                            @case("public")
                                {{-- <span class="badge bg-success text-white"><i class="ri-eye-fill"></i></span> --}}
                                @break
                            @case("p2p")
                                <span class="badge bg-warning text-dark"><i class="ri-eye-off-fill"></i></span>
                                @break
                            @case("private")
                                <span class="badge bg-danger text-white"><i class="ri-lock-fill"></i></span>
                                @break
                            @case("groupShow")
                                <span class="badge bg-success text-white"><i class="ri-group-line"></i></span>
                                @break
                            @default
                                {{ $status }}
                        @endswitch
                    @endif
                </div>
            @endif
        </div>

        <div class="card-content text-center">
            <h6 class="text-truncate">{{ $username }}</h6>
        </div>
    </a>
</div>
