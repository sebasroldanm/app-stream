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
            <div class="related-models-wrapper position-relative px-5">

                <div class="swiper related-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($related->models as $item)
                            <div class="swiper-slide">
                                <x-ownerInfoCard :owner="$item" :favs="$favs" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="swiper-button-next custom-arrow"></div>
                <div class="swiper-button-prev custom-arrow"></div>

            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">{{ __('owner/related.no_related_models') }}</p>
            </div>
        @endif
    </div>
</div>
