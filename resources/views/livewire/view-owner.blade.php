<div id="content-page" class="content-page" data-id_owner="{{ $owner->id }}">
    {{-- @php
        $owner->data = json_decode($owner->data, true);
    @endphp --}}
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body profile-page p-0">
                        <div class="profile-header">
                            <div class="position-relative intro-owner container-overlay">
                                @if (in_array($intro->type, ['image', 'avatar']))
                                    <img src="{{ $intro->url }}" alt="profile-bg"
                                        class="rounded img-fluid _overlay @if ($intro->type == 'avatar') blur_avatar @endif">
                                @else
                                    <video autoplay loop muted class="rounded _overlay">
                                        <source src="{{ $intro->url }}" type="video/mp4">
                                    </video>
                                @endif


                                <ul class="header-nav list-inline d-flex flex-wrap justify-end p-0 m-0">
                                    @if ($error_search)
                                        <li>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Reportado por lentitud"
                                                class="username_reported">
                                                <i class="las la-exclamation-triangle"></i>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a wire:click="toggleFavorite" href="javascript:void(0);"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="@if ($is_fav) Eliminar de favoritos @else Agregar a favoritos @endif"
                                            @if ($is_fav) class="delete_favorite" @endif>
                                            <i
                                                @if ($is_fav) class="las la-heart" @else class="lar la-heart" @endif></i>
                                        </a>
                                    </li>
                                    @if ($owner->isError)
                                        <li><a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Username no válido">
                                                <i class="ri-alert-line"></i>
                                            </a></li>
                                    @else
                                        <li><a wire:click="updateDataMod" href="javascript:void(0);"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="Actualizar">
                                                <i class="ri-refresh-line"></i>
                                            </a></li>
                                    @endif
                                    @if (isset($owner->data->user->modelTopPosition) && $owner->data->user->modelTopPosition->position !== 0)
                                        <li><a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-original-title="Posición: {{ $owner->data->user->modelTopPosition->position }}">
                                                <i class="las la-trophy"></i>
                                            </a></li>
                                    @else
                                        @if (isset($owner->data->usercurrPosition) && $owner->data->usercurrPosition !== 0)
                                            <li><a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="Posición: {{ $owner->data->user->modelTopPosition->position }}">
                                                    <i class="las la-trophy"></i>
                                                </a></li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                            <div class="user-detail text-center mb-3">
                                <div class="profile-img">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $owner->pic_profile }}" alt="profile-img"
                                            class="avatar-130 img-fluid @if ($owner->isLive) live @endif" />
                                    </a>
                                </div>
                                <div class="profile-detail">
                                    <h3 class="">{{ $owner->username }}
                                        @if ($owner->isOnline)
                                            <i class="ri-checkbox-blank-circle-fill online m-2" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="Online"></i>
                                        @else
                                            @if ($owner->isDelete)
                                                <i class="ri-close-circle-fill disable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="Desactivado"></i>
                                            @else
                                                <i class="ri-indeterminate-circle-fill offline" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="Offline"></i>
                                            @endif
                                        @endif
                                    </h3>
                                </div>
                            </div>
                            <div
                                class="profile-info p-3 d-flex align-items-center justify-content-between position-relative">
                                <div class="social-links">
                                    <ul
                                        class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                                        @if ($owner->data)
                                            @isset($owner->data->user->socialLinksData)
                                                @isset($owner->data->user->socialLinksData->twitter)
                                                    <li class="text-center pe-3">
                                                        <a href="{{ $owner->data->user->socialLinksData->twitter->link }}"
                                                            target="_blank">
                                                            <img src="{{ asset('/images/icon/09.png') }}"
                                                                class="img-fluid rounded" alt="Twitter"></a>
                                                    </li>
                                                @endisset
                                                @isset($owner->data->user->socialLinksData->instagram)
                                                    <li class="text-center pe-3">
                                                        <a href="{{ $owner->data->user->socialLinksData->instagram->link }}"
                                                            target="_blank">
                                                            <img src="{{ asset('/images/icon/10.png') }}"
                                                                class="img-fluid rounded" alt="Instagram"></a>
                                                    </li>
                                                @endisset
                                                {{-- <li class="text-center pe-3">
                                                    <a href="#"><img src="{{ asset('/images/icon/08.png') }}"
                                                            class="img-fluid rounded" alt="facebook"></a>
                                                </li>


                                                <li class="text-center pe-3">
                                                    <a href="#"><img src="{{ asset('/images/icon/11.png') }}"
                                                            class="img-fluid rounded" alt="Google plus"></a>
                                                </li>
                                                <li class="text-center pe-3">
                                                    <a href="#"><img src="{{ asset('/images/icon/12.png') }}"
                                                            class="img-fluid rounded" alt="You tube"></a>
                                                </li>
                                                <li class="text-center md-pe-3 pe-0">
                                                    <a href="#"><img src="{{ asset('/images/icon/13.png') }}"
                                                            class="img-fluid rounded" alt="linkedin"></a>
                                                </li> --}}
                                            @endisset
                                        @endif
                                    </ul>
                                </div>
                                <div class="social-info">
                                    @if ($owner->data)
                                        <ul
                                            class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                                            <li class="text-center ps-3">
                                                <h6>Fotos</h6>
                                                <p class="mb-0">{{ $owner->data->user->photosCount }}</p>
                                            </li>
                                            <li class="text-center ps-3">
                                                <h6>Videos</h6>
                                                <p class="mb-0">{{ $owner->data->user->videosCount }}</p>
                                            </li>
                                            <li class="text-center ps-3">
                                                <h6>Favoritos</h6>
                                                <p class="mb-0">{{ $owner->data->user->user->favoritedCount }}</p>
                                            </li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="user-tabing">
                            <ul
                                class="nav nav-pills d-flex align-items-center justify-content-center profile-feed-items p-0 m-0">
                                @if ($owner->isLive)
                                    <li class="nav-item col-12 col-sm-2 p-0">
                                        <a class="nav-link live @if ($showLive) active @endif "
                                            href="#pills-live-tab" data-bs-toggle="pill" data-bs-target="#live"
                                            role="button" wire:click="loadComponent('live')">Live<div class="live-icon"></div></a>
                                    </li>
                                @endif
                                <li class="nav-item col-12 @if ($owner->isLive) col-sm-2 @else col-sm-3 @endif p-0">
                                    <a class="nav-link @if ($showFeed) active @endif"
                                        href="#pills-feed-tab" data-bs-toggle="pill" data-bs-target="#feed"
                                        role="button" wire:click="loadComponent('feed')">Feed</a>
                                </li>
                                <li class="nav-item col-12 col-sm-3 p-0">
                                    <a class="nav-link @if ($showInformation) active @endif"
                                        href="#pills-info-tab" data-bs-toggle="pill" data-bs-target="#infomation"
                                        role="button" wire:click="loadComponent('information')">Información</a>
                                </li>
                                <li class="nav-item col-12 @if ($owner->isLive) col-sm-2 @else col-sm-3 @endif p-0">
                                    <a class="nav-link @if ($showAlbums) active @endif"
                                        href="#pills-albums-tab" data-bs-toggle="pill"
                                        wire:click="loadComponent('albums')" data-bs-target="#albums"
                                        role="button">Albums</a>
                                </li>
                                <li class="nav-item col-12 col-sm-3 p-0">
                                    <a class="nav-link @if ($showVideos_) active @endif"
                                        href="#pills-videos-tab" data-bs-toggle="pill"
                                        wire:click="loadComponent('videos')" data-bs-target="#videos"
                                        role="button">Videos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="tab-content">
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showLive) show active @endif" id="live"
                        role="tabpanel">
                        @if ($showLive)
                            @livewire('owner.live', ['owner' => $owner])
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showFeed) show active @endif" id="feed"
                        role="tabpanel">
                        @if ($showFeed)
                            @livewire('owner.feed', ['owner' => $owner])
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showInformation) show active @endif" id="infomation"
                        role="tabpanel">
                        @if ($showInformation)
                            @livewire('owner.information', ['owner' => $owner])
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showAlbums) show active @endif" id="albums"
                        role="tabpanel">
                        @if ($showAlbums)
                            @livewire('owner.albums', ['owner' => $owner])
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showVideos_) show active @endif" id="videos"
                        role="tabpanel">
                        @if ($showVideos_)
                            @livewire('owner.videos', ['owner' => $owner])
                        @endif
                    </div>
                </div>
            </div>
            <div wire:loading class="col-sm-12 text-center">
                <img src="{{ asset('images/page-img/page-load-loader.gif ') }}" alt="loader"
                    style="height: 100px;">
            </div>
        </div>
    </div>
</div>
