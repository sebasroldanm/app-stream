<div id="content-page" class="content-page" data-id_owner="{{ $owner->id }}"
    @if ($owner->isLive) wire:init="verifyAsync" @endif>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if ($owner->isBirthday())
                    <div id="birthday-alert" class="alert text-white bg-success" role="alert">
                        <div class="text-center"><i class="ri-cake-2-line"></i> ¡Feliz cumpleaños {{ $owner->name }}!</div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body profile-page p-0">
                        <div class="profile-header">
                            @if (in_array($intro->type, ['image', 'avatar']))
                                <div class="ambient">
                                    <img src="{{ $intro->url }}" alt="profile-bg" class="img-fluid intro-owner w-100 object-fit-cover">
                                </div>
                            @else
                                @if ($showLive)
                                    <div class="ambient">
                                        <img src="{{ $intro->intro_image_url }}" alt="profile-bg" onerror="this.style.display='none';"
                                            class="img-fluid intro-owner w-100 object-fit-cover">
                                    </div>
                                @else
                                    <video class="ambient" autoplay muted loop>
                                        <source src="{{ $intro->url }}" type="video/mp4">
                                    </video>
                                @endif
                            @endif
                            <div class="position-relative intro-owner container-overlay">
                                @if (in_array($intro->type, ['image', 'avatar']))
                                    <img src="{{ $intro->url }}" alt="profile-bg" onerror="this.style.display='none';"
                                        class="rounded img-fluid _overlay @if ($intro->type == 'avatar') blur_avatar @endif fullviewer">
                                @else
                                    @if ($showLive)
                                        <img src="{{ $intro->intro_image_url }}" alt="profile-bg" onerror="this.style.display='none';"
                                            class="rounded img-fluid _overlay fullviewer">
                                    @else
                                        <video id="fullviewer-video" autoplay muted loop class="rounded _overlay">
                                            <source src="{{ $intro->url }}" type="video/mp4">
                                        </video>
                                    @endif
                                @endif

                                <ul class="header-nav list-inline d-flex flex-wrap justify-end p-0 m-0">
                                    @if ($isBanned)
                                        <li>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-original-title="{{ __('owner/information/details.banned_or_blocked') }}"
                                                class="username_reported">
                                                <i class="las la-ban"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($error_search)
                                        <li>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-original-title="{{ __('owner/information/details.reported_slowness') }}"
                                                class="username_reported">
                                                <i class="las la-exclamation-triangle"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($is_related && $is_related->count() > 0)
                                        <li>
                                            <a href="{{ route('owner.information', $owner->username) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="{{ __('owner/information/details.related_count', ['count' => $is_related->count()]) }}">
                                                <i class="las la-link"></i>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a wire:click="toggleFavorite" href="javascript:void(0);"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="{{ $is_fav ? __('owner/profile.remove_favorite') : __('owner/profile.add_favorite') }}"
                                            @if ($is_fav) class="delete_favorite" @endif>
                                            <i
                                                @if ($is_fav) class="las la-heart" @else class="lar la-heart" @endif></i>
                                        </a>
                                    </li>
                                    @if ($owner->notFound)
                                        @if (!$force_sync)
                                            <li><a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                    wire:click="force_sync_enable" data-bs-placement="top"
                                                    data-bs-original-title="{{ __('owner/information/details.not_found_origin_unlock') }}">
                                                    <i class="ri-alert-line"></i>
                                                </a></li>
                                        @else
                                            <li>
                                                <a href="javascript:void(0);" 
                                                wire:click="updateDataMod"
                                                wire:loading.attr="disabled"
                                                wire:target="updateDataMod"
                                                class="refresh-button">
                                                
                                                    <i class="ri-refresh-line" 
                                                    wire:loading.class="ri-spin-fade" 
                                                    wire:target="updateDataMod"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        <li>
                                            <a href="javascript:void(0);" 
                                            wire:click="updateDataMod"
                                            wire:loading.attr="disabled"
                                            wire:target="updateDataMod"
                                            class="refresh-button">
                                            
                                                <i class="ri-refresh-line" 
                                                wire:loading.class="ri-spin-fade" 
                                                wire:target="updateDataMod"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="user-detail text-center mb-3">
                                <div class="profile-img">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $owner->pic_profile }}" alt="profile-img"
                                            class="avatar-130 img-fluid @if ($owner->isLive) live @endif fullviewer" />
                                    </a>
                                </div>
                                <div class="profile-detail">
                                    <h3 class="">{{ $owner->username }}
                                        @if ($owner->isOnline)
                                            <i class="ri-checkbox-blank-circle-fill online m-2" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-original-title="{{ __('owner/profile.online') }}"></i>
                                        @else
                                            @if ($owner->isDelete)
                                                <i class="ri-close-circle-fill disable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="{{ __('owner/profile.disabled') }}"></i>
                                            @elseif ($owner->notFound)
                                                <i class="ri-close-circle-fill disable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="{{ __('owner/profile.not_found_origin') }}"></i>
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
                                                <h6>{{ __('owner/profile.photos') }}</h6>
                                                <p class="mb-0">{{ $owner->data->user->photosCount }}</p>
                                            </li>
                                            <li class="text-center ps-3">
                                                <h6>{{ __('owner/profile.videos') }}</h6>
                                                <p class="mb-0">{{ $owner->data->user->videosCount }}</p>
                                            </li>
                                            <li class="text-center ps-3">
                                                <h6>{{ __('owner/profile.favorites') }}</h6>
                                                <p class="mb-0">
                                                    {{ number_format($owner->data->user->user->favoritedCount, 0, ',', '.') }}
                                                </p>
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
                                        <a 
                                            href="{{ route('owner.live', ['username' => $owner->username]) }}"
                                            class="nav-link live @if ($showLive) active @endif">
                                            @if ($owner->show_mode)<i class="fa fa-lock" aria-hidden="true"></i>@endif {{ __('owner/tabs.live') }} <div class="live-icon"></div>
                                        </a>
                                    </li>
                                @endif

                                <li
                                    class="nav-item col-6 @if ($owner->isLive) col-sm-2 @else col-sm-3 @endif p-0">
                                    <a
                                        href="{{ route('owner.feed', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showFeed) active @endif">
                                        {{ __('owner/tabs.feed') }}
                                    </a>
                                </li>

                                <li class="nav-item col-6 col-sm-3 p-0">
                                    <a
                                        href="{{ route('owner.information', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showInformation) active @endif">
                                        {{ __('owner/tabs.info') }}
                                    </a>
                                </li>

                                <li
                                    class="nav-item col-6 @if ($owner->isLive) col-sm-2 @else col-sm-3 @endif p-0">
                                    <a
                                        href="{{ route('owner.albums', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showAlbums) active @endif">
                                        {{ __('owner/tabs.albums') }}
                                    </a>
                                </li>

                                <li class="nav-item col-6 col-sm-3 p-0">
                                    <a
                                        href="{{ route('owner.videos', ['username' => $owner->username]) }}"
                                        class="nav-link @if ($showVideos) active @endif">
                                        {{ __('owner/tabs.videos') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="tab-content">

                <div class="tab-pane fade @if ($showLive) show active @endif" id="live"
                    role="tabpanel" wire:key="tab-pane-live-{{ $owner->id }}">
                    @if ($showLive)
                        <div id="container-live" class="container" wire:key="container-live-{{ $owner->id }}">
                            <livewire:owner.live :owner="$owner" wire:key="live-component-{{ $owner->id }}" />
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade @if ($showFeed) show active @endif" id="feed"
                    role="tabpanel" wire:key="tab-pane-feed-{{ $owner->id }}">
                    @if ($showFeed)
                        <div class="container" wire:key="container-feed-{{ $owner->id }}">
                            <livewire:owner.feed :owner="$owner" wire:key="feed-component-{{ $owner->id }}" />
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade @if ($showInformation) show active @endif" id="infomation"
                    role="tabpanel" wire:key="tab-pane-info-{{ $owner->id }}">
                    @if ($showInformation)
                        <div class="container" wire:key="container-info-{{ $owner->id }}">
                            <livewire:owner.information :owner="$owner" wire:key="info-component-{{ $owner->id }}" />
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade @if ($showAlbums) show active @endif" id="albums"
                    role="tabpanel" wire:key="tab-pane-albums-{{ $owner->id }}">
                    @if ($showAlbums)
                        <div class="container" wire:key="container-albums-{{ $owner->id }}">
                            <livewire:owner.albums :owner="$owner" wire:key="albums-component-{{ $owner->id }}" />
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade @if ($showVideos) show active @endif" id="videos"
                    role="tabpanel" wire:key="tab-pane-videos-{{ $owner->id }}">
                    @if ($showVideos)
                        <div class="container" wire:key="container-videos-{{ $owner->id }}">
                            <livewire:owner.videos :owner="$owner" wire:key="videos-component-{{ $owner->id }}" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container" wire:key="container-related-{{ $owner->id }}">
        <livewire:owner.related :owner="$owner" wire:key="related-component-{{ $owner->id }}" />
    </div>
</div>