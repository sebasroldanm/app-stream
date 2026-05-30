<div class="card card-block card-stretch card-height">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="header-title">
            <h4 class="card-title">{{ __('owner/tabs.relations') }}</h4>
        </div>
        <div class="card-header-toolbar d-flex align-items-center">
            <a href="{{ route('metadata', ['model' => 'related', 'id' => $owner->username]) }}"
                class="btn btn-sm btn-soft-primary" target="_blank">
                <i class="fas fa-link me-0"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        @if (!empty($related) && count($related->models) > 0)
            <div class="related-models-wrapper position-relative px-5"
                 x-data="{
                    swiper: null,
                    init() {
                        const container = this.$refs.swiperContainer;
                        const slides = container.querySelectorAll('.swiper-slide');
                        const canLoop = slides.length > 5;
                        
                        this.swiper = new Swiper(container, {
                            pauseOnMouseEnter: true,
                            slidesPerView: 2,
                            slidesPerGroup: 2,
                            spaceBetween: 15,
                            loop: canLoop,
                            autoplay: canLoop ? {
                                delay: 30000,
                                disableOnInteraction: true,
                            } : false,
                            navigation: {
                                nextEl: this.$refs.nextBtn,
                                prevEl: this.$refs.prevBtn,
                            },
                            breakpoints: {
                                640: {
                                    slidesPerView: 2,
                                    slidesPerGroup: 2,
                                },
                                1024: {
                                    slidesPerView: 4,
                                    slidesPerGroup: 3,
                                },
                                1400: {
                                    slidesPerView: 5,
                                    slidesPerGroup: 3,
                                },
                            },
                        });
                    },
                    destroy() {
                        if (this.swiper) this.swiper.destroy(true, true);
                    }
                 }">

                <div x-ref="swiperContainer" class="swiper related-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($related->models as $item)
                            <div class="swiper-slide">
                                <x-ownerInfoCard
                                    :isFav="in_array($item->id, $favs)"
                                    :primaryImage="(isset($item->verifiedSnapshotTimestamp) && $item->verifiedSnapshotTimestamp) ? 'https://img.doppiocdn.net/thumbs/' . $item->verifiedSnapshotTimestamp . '/' . $item->id : null"
                                    :secondaryImage="$item->previewUrlThumbSmall"
                                    :ternaryImage="(isset($item->popularSnapshotTimestamp) && $item->popularSnapshotTimestamp) ? 'https://img.doppiocdn.net/thumbs/' . $item->popularSnapshotTimestamp . '/' . $item->id : null"
                                    :isNew="$item->isNew"
                                    :isMobile="$item->isMobile"
                                    :viewersCount="$item->viewersCount"
                                    :username="$item->username"
                                    :idOwner="$item->id"
                                    :settings="[
                                        'autoplay' => false,
                                        'allowTouchMove' => false,
                                        'simulateTouch' => false,
                                    ]"
                                    :status="$item->status"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div x-ref="nextBtn" class="swiper-button-next custom-arrow"></div>
                <div x-ref="prevBtn" class="swiper-button-prev custom-arrow"></div>

            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">{{ __('owner/related.no_related_models') }}</p>
            </div>
        @endif
    </div>
</div>
