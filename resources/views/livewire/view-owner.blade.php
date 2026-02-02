<div id="content-page" class="content-page" data-id_owner="{{ $owner->id }}"
    @if ($owner->isLive) wire:init="verifyAsync" @endif>
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
                                    <img src="{{ $intro->url }}" alt="profile-bg" onerror="this.style.display='none';"
                                        class="rounded img-fluid _overlay @if ($intro->type == 'avatar') blur_avatar @endif fullviewer">
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
                                    @if ($is_related && $is_related->count() > 0)
                                        <li>
                                            <a href="{{ route('owner.information', $owner->username) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="{{ $is_related->count() }} Relacionados">
                                                <i class="las la-link"></i>
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
                                    @if ($owner->notFound)
                                        @if (!$force_sync)
                                            <li><a href="javascript:void(0);" data-bs-toggle="tooltip" wire:click="force_sync_enable"
                                                    data-bs-placement="top" data-bs-original-title="No encontrado en el Servidor principal, desbloquear para buscar">
                                                    <i class="ri-alert-line"></i>
                                                </a></li>
                                        @else
                                            <li><a href="javascript:void(0);" data-bs-toggle="tooltip" wire:click="updateDataMod"
                                                    data-bs-placement="top" data-bs-original-title="No encontrado en el Servidor principal, buscar en similitudes">
                                                    <i class="ri-refresh-line"></i>
                                                </a></li>
                                        @endif
                                    @else
                                        <li><a wire:click="updateDataMod" href="javascript:void(0);"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="Actualizar">
                                                <i class="ri-refresh-line"></i>
                                            </a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="user-detail text-center mb-3">
                                <div class="profile-img">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $owner->pic_profile }}" alt="profile-img"
                                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $owner->username }}';"
                                            class="avatar-130 img-fluid @if ($owner->isLive) live @endif fullviewer" />
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
                                            @elseif ($owner->notFound)
                                                <i class="ri-close-circle-fill disable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="No encontrado Origin Server"></i>
                                            @else
                                                <i class="ri-indeterminate-circle-fill offline" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="{{ \Carbon\Carbon::parse($owner->statusChangedAt)->diffForHumans() }}"></i>
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
                                        <a wire:navigate
                                            href="{{ route('owner.live', ['username' => $owner->username]) }}"
                                            class="nav-link live @if ($showLive) active @endif"
                                            data-bs-toggle="pill" data-bs-target="#live" role="button">
                                            Live <div class="live-icon"></div>
                                        </a>
                                    </li>
                                @endif

                                <li
                                    class="nav-item col-12 @if ($owner->isLive) col-sm-2 @else col-sm-3 @endif p-0">
                                    <a wire:navigate
                                        href="{{ route('owner.feed', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showFeed) active @endif"
                                        data-bs-toggle="pill" data-bs-target="#feed" role="button">
                                        Feed
                                    </a>
                                </li>

                                <li class="nav-item col-12 col-sm-3 p-0">
                                    <a wire:navigate
                                        href="{{ route('owner.information', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showInformation) active @endif"
                                        data-bs-toggle="pill" data-bs-target="#infomation" role="button">
                                        Información
                                    </a>
                                </li>

                                <li
                                    class="nav-item col-12 @if ($owner->isLive) col-sm-2 @else col-sm-3 @endif p-0">
                                    <a wire:navigate
                                        href="{{ route('owner.albums', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showAlbums) active @endif"
                                        data-bs-toggle="pill" data-bs-target="#albums" role="button">
                                        Albums
                                    </a>
                                </li>

                                <li class="nav-item col-12 col-sm-3 p-0">
                                    <a wire:navigate
                                        href="{{ route('owner.videos', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showVideos) active @endif"
                                        data-bs-toggle="pill" data-bs-target="#videos" role="button">
                                        Videos
                                    </a>
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
                            <livewire:owner.live :owner="$owner" lazy />
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showFeed) show active @endif" id="feed"
                        role="tabpanel">
                        @if ($showFeed)
                            <livewire:owner.feed :owner="$owner" lazy />
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showInformation) show active @endif" id="infomation"
                        role="tabpanel">
                        @if ($showInformation)
                            <livewire:owner.information :owner="$owner" lazy />
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showAlbums) show active @endif" id="albums"
                        role="tabpanel">
                        @if ($showAlbums)
                            <livewire:owner.albums :owner="$owner" lazy />
                        @endif
                    </div>
                    <div wire:loading.remove
                        class="tab-pane fade @if ($showVideos) show active @endif" id="videos"
                        role="tabpanel">
                        @if ($showVideos)
                            <livewire:owner.videos :owner="$owner" lazy />
                        @endif
                    </div>
                </div>
            </div>
            <div wire:loading class="col-sm-12 text-center">
                <img src="{{ asset('images/page-img/page-load-loader.gif ') }}" alt="loader"
                    style="height: 100px;">
            </div>
            <livewire:owner.related :owner="$owner" lazy />
        </div>
    </div>
</div>
