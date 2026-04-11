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
                                <div class="user-post-data position-relative">
                                    <a href="{{ route('owner', $item->username) }}" class="d-block">
                                        <div
                                            class="image-container overflow-hidden rounded shadow-sm position-relative">
                                            <img src="{{ $item->previewUrlThumbSmall }}"
                                                class="img-fluid w-100 object-cover"
                                                style="height: 180px; object-fit: cover;" alt="{{ $item->username }}">

                                            <div class="position-absolute top-0 start-0 m-1">
                                                <span class="badge bg-dark-50 text-white shadow-sm">
                                                    <i
                                                        class="las {{ $item->isMobile ? 'la-mobile-alt' : 'la-laptop' }}"></i>
                                                </span>
                                            </div>

                                            @if ($item->isNew)
                                                <div class="position-absolute top-0 end-0 m-1">
                                                    <span
                                                        class="badge bg-warning text-dark fw-bold">{{ __('owner/related.new') }}</span>
                                                </div>
                                            @endif

                                            <div class="position-absolute bottom-0 end-0 m-2">
                                                <span class="badge bg-dark text-white opacity-75">
                                                    {{ $item->viewersCount }} <i class="las la-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-center">
                                            <h6 class="mb-0 text-truncate">{{ $item->username }}</h6>
                                            @if (in_array($item->id, $favs))
                                                <i class="las la-heart text-danger"></i>
                                            @endif
                                        </div>
                                    </a>
                                </div>
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
