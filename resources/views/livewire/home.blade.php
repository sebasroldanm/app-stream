<!-- Page Content  -->
<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg7.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Novedades</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-4">
                    <label>Username:</label>
                    <div class="col-sm-12">
                        <input wire:model="search" wire:input.debounce.500ms="searchByText" class="form-control"
                            type="search" placeholder="Ingresa el username">
                    </div>
                </div>
                <div class="offset-2 col-md-2">
                    <label>Favoritas:</label>
                    <select class="form-select" wire:change="ListFavorites">
                        <option value="true">No</option>
                        <option value="false">Si</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label>Live:</label>
                    <select class="form-select" wire:change="listLivesChange">
                        <option value="desc">No</option>
                        <option value="asc">Si</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Ordenar nuevos owners:</label>
                    <select class="form-select" wire:change="order" wire:model="orderDir">
                        <option value="asc">Asecdendente</option>
                        <option value="desc">Descendente</option>
                    </select>
                </div>
            </div>
            <div class="d-grid gap-3 d-grid-template-1fr-19">
                {{-- <div class="card mb-0">
                    <div class="top-bg-image">
                        <img src="{{ asset('/images/page-img/profile-bg1.jpg') }}" class="img-fluid w-100"
                            alt="group-bg">
                    </div>
                    <div class="card-body text-center">
                        <div class="group-icon">
                            <img src="{{ asset('/images/page-img/gi-1.jpg') }}" alt="profile-img"
                                class="rounded-circle img-fluid avatar-120">
                        </div>
                        <div class="group-info pt-3 pb-3">
                            <h4><a href="../app/group-detail.html">Designer</a></h4>
                            <p>Lorem Ipsum data</p>
                        </div>
                        <div class="group-details d-inline-block pb-3">
                            <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                <li class="pe-3 ps-3">
                                    <p class="mb-0">Post</p>
                                    <h6>600</h6>
                                </li>
                                <li class="pe-3 ps-3">
                                    <p class="mb-0">Member</p>
                                    <h6>320</h6>
                                </li>
                                <li class="pe-3 ps-3">
                                    <p class="mb-0">Visit</p>
                                    <h6>1.2k</h6>
                                </li>
                            </ul>
                        </div>
                        <div class="group-member mb-3">
                            <div class="iq-media-group">
                                <a href="#" class="iq-media">
                                    <img class="img-fluid avatar-40 rounded-circle"
                                        src="{{ asset('/images/user/05.jpg') }}" alt="">
                                </a>
                                <a href="#" class="iq-media">
                                    <img class="img-fluid avatar-40 rounded-circle"
                                        src="{{ asset('/images/user/06.jpg') }}" alt="">
                                </a>
                                <a href="#" class="iq-media">
                                    <img class="img-fluid avatar-40 rounded-circle"
                                        src="{{ asset('/images/user/07.jpg') }}" alt="">
                                </a>
                                <a href="#" class="iq-media">
                                    <img class="img-fluid avatar-40 rounded-circle"
                                        src="{{ asset('/images/user/08.jpg') }}" alt="">
                                </a>
                                <a href="#" class="iq-media">
                                    <img class="img-fluid avatar-40 rounded-circle"
                                        src="{{ asset('/images/user/09.jpg') }}" alt="">
                                </a>
                                <a href="#" class="iq-media">
                                    <img class="img-fluid avatar-40 rounded-circle"
                                        src="{{ asset('/images/user/10.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-block w-100">Join</button>
                    </div>
                </div> --}}
                @foreach ($owners as $owner)
                    @php
                        $owner->data = json_decode($owner->data);
                    @endphp
                    <div class="card mb-0 card_owner_home">
                        <div class="top-bg-image top-bg-list-owner container-overlay">
                            @if ($owner->data)
                                <img src="{{ $owner->data->user->user->previewUrlThumbSmall }}" loading="lazy"
                                    class="img-fluid w-100 _overlay" alt="group-bg">
                            @else
                                <img src="https://placehold.co/320x110?text=No+Imagen" class="img-fluid w-100 _overlay"
                                    loading="lazy" alt="group-bg">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <div class="group-icon">
                                @if ($owner->pic_profile)
                                    <img src="{{ $owner->pic_profile }}" alt="profile-img" loading="lazy"
                                        class="rounded-circle img-fluid avatar-120">
                                @else
                                    @if ($owner->avatar)
                                        <img src="{{ $owner->avatar }}" alt="profile-img" loading="lazy"
                                            class="rounded-circle img-fluid avatar-120">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ $owner->username }}" alt="profile-img"
                                            loading="lazy" class="rounded-circle img-fluid avatar-120">
                                    @endif
                                @endif
                            </div>
                            <div class="group-info pt-3 pb-3">
                                <h4>
                                    <a href="{{ route('owner.feed', $owner->username) }}" wire:navigate>
                                        {{ $owner->username }}
                                        @if ($owner->isLive)
                                            <div class="live-icon"></div>
                                        @else
                                            @if ($owner->isOnline)
                                                <i class="ri-checkbox-blank-circle-fill online m-1"></i>
                                            @endif
                                        @endif
                                    </a>
                                </h4>
                                @if ($owner->name)
                                    <p>
                                        @if (in_array($owner->id, $favs))
                                            <span class="badge bg-danger"><i class="las la-heart"></i></span>
                                            {{ $owner->name }}
                                        @else
                                            {{ $owner->name }}
                                        @endif
                                    </p>
                                @else
                                    <p>
                                        @if (in_array($owner->id, $favs))
                                            <span class="badge bg-danger"><i class="las la-heart"></i></span>&nbsp;
                                        @else
                                            &nbsp;
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div class="group-details d-inline-block pb-3">
                                <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Fotos</p>
                                        @if ($owner->data)
                                            <h6>{{ $owner->data->user->photosCount }}</h6>
                                        @else
                                            <h6>-</h6>
                                        @endif
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Videos</p>
                                        @if ($owner->data)
                                            <h6>{{ $owner->data->user->videosCount }}</h6>
                                        @else
                                            <h6>-</h6>
                                        @endif
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Ranking</p>
                                        @if ($owner->data)
                                            @if (isset($owner->data->user->modelTopPosition->position) && $owner->data->user->modelTopPosition->position !== 0)
                                                <h6>{{ $owner->data->user->modelTopPosition->position }}</h6>
                                            @else
                                                <h6>-</h6>
                                            @endif
                                        @else
                                            <h6>-</h6>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            @if ($owner->latestSnapshots->count() > 0)
                                <div class="group-member mb-3">
                                    <div class="iq-media-group">
                                        @foreach ($owner->latestSnapshots as $snapshot)
                                            <a href="{{ route('owner.feed', $owner->username) }}" class="iq-media">
                                                <img class="img-fluid avatar-40 rounded-circle"
                                                    src="{{ URL::to('/') . $snapshot->local_url }}"
                                                    onerror="this.onerror=null; this.src='https://placehold.co/50x50.jpg?text=:(';"
                                                    alt="">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($owner->isError)
                                <button class="btn btn-danger d-block w-100"><i class="las la-exclamation-triangle"></i>
                                    No encontrado</button>
                            @else
                                <a href="{{ route('owner.feed', $owner->username) }}" type="submit"
                                    class="btn btn-primary d-block w-100">Ver perfil</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($owners->isEmpty())
                <div class="row mt-3">
                    <div class="offset-3 col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="email">Digita owner para ingresar:</label>
                            <input type="text" class="form-control" id="owner" wire:model="newOwner"
                                value="{{ $newOwner }}">
                        </div>
                        <button type="submit" class="btn btn-primary" wire:click="addOwner">Insertar</button>
                    </div>
                </div>
            @else
                <div x-intersect="$wire.loadMore()" class="col-sm-12 text-center p-4">
                    <div wire:loading wire:target="loadMore">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
