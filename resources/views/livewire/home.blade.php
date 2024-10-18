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
                        <input wire:model="search" wire:keyup.debounce.500ms="searchByText"
                            class="form-control" type="search" placeholder="Ingresa el username">
                    </div>
                </div>
                <div class="offset-5 col-md-3">
                    <label>Ordenar nuevos owners: </label>
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
                @foreach ($mods as $mod)
                    @php
                        $mod->data = json_decode($mod->data);
                    @endphp
                    <div class="card mb-0">
                        <div class="top-bg-image" style="height: 110px; overflow: hidden;">
                            @if ($mod->data)
                                <img style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                    src="{{ $mod->data->user->user->previewUrlThumbSmall }}" class="img-fluid w-100"
                                    alt="group-bg">
                            @else
                                <img src="https://placehold.co/320x110?text=No+Imagen" class="img-fluid w-100"
                                    alt="group-bg">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <div class="group-icon">
                                @if ($mod->avatar)
                                    <img src="{{ $mod->avatar }}" alt="profile-img"
                                        class="rounded-circle img-fluid avatar-120">
                                @else
                                    <img src="https://placehold.co/300x300?text=No+Imagen" alt="profile-img"
                                        class="rounded-circle img-fluid avatar-120">
                                @endif
                            </div>
                            <div class="group-info pt-3 pb-3">
                                <h4><a href="../app/group-detail.html">{{ $mod->username }}</a></h4>
                                @if ($mod->name)
                                    <p>{{ $mod->name }}</p>
                                @else
                                    <p>&nbsp;</p>
                                @endif
                            </div>
                            <div class="group-details d-inline-block pb-3">
                                <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Fotos</p>
                                        @if ($mod->data)
                                            <h6>{{ $mod->data->user->photosCount }}</h6>
                                        @else
                                            <h6>-</h6>
                                        @endif
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Videos</p>
                                        @if ($mod->data)
                                            <h6>{{ $mod->data->user->videosCount }}</h6>
                                        @else
                                            <h6>-</h6>
                                        @endif
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Ranking</p>
                                        @if ($mod->data)
                                            @if (isset($mod->data->user->modelTopPosition->position) && $mod->data->user->modelTopPosition->position !== 0)
                                                <h6>{{ $mod->data->user->modelTopPosition->position }}</h6>
                                            @else
                                                <h6>-</h6>
                                            @endif
                                        @else
                                            <h6>-</h6>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            {{-- <div class="group-member mb-3">
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
                            </div> --}}
                            <a href="{{ route('view.owner', $mod->username) }}" type="submit"
                                class="btn btn-primary d-block w-100">Ver detalle</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-3">
                <div class="offset-4 col-md-4 text-center">
                    <button type="button" wire:click="moreLimit" class="btn btn-soft-primary mb-1">Ver más</button>
                    <button type="button" wire:click="lessLimit" class="btn btn-soft-primary mb-1">Ver menos</button>
                </div>
            </div>
        </div>
    </div>
</div>
