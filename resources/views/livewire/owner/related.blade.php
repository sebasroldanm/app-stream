<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h4 class="mb-3">Modelos Relacionados</h4>
                <a href="{{ route('metadata', ['model' => 'related', 'id' => $owner->username]) }}" target="_blank">
                    <i class="fas fa-link"></i>
                </a>
            </div>
            @if (!empty($related) && count($related->models) > 0)
                <div class="swiper related-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($related->models as $related)
                            <div class="swiper-slide">
                                <a href="{{ route('owner', $related->username) }}" class="card">
                                    <div class="image-container container-overlay">
                                        <img src="{{ $related->previewUrlThumbSmall }}"
                                            class="card-img-top primary-image _overlay" alt="{{ $related->username }}">
                                    </div>
                                    <div class="card-body p-1">
                                        <p class="m-0">{{ $related->username }}</p>
                                    </div>
                                    <div class="s_icon top right">
                                        @if ($related->isNew)
                                            <h5 class="m-0">
                                                <span class="badge badge-pill bg-warning">New</span>
                                            </h5>
                                        @endif
                                        @if (in_array($related->id, $favs))
                                            <i class="las la-heart favorite_icon"></i>
                                        @endif
                                    </div>
                                    <div class="s_icon top left">
                                        <h5>
                                            <span class="badge badge-pill bg-dark">
                                                @if ($related->isMobile)
                                                    <i class="las la-mobile-alt"></i>
                                                @else
                                                    <i class="las la-laptop"></i>
                                                @endif
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="s_icon bottom right">
                                        <h5>
                                            <span class="badge badge-pill bg-dark">
                                                {{ $related->viewersCount }} <i class="las la-eye"></i>
                                            </span>
                                        </h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="col-md-12">
                    <p class="text-center">No hay modelos relacionados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
