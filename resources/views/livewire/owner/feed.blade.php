<div class="card-body p-0">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Detalles</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="event-post position-relative">
                                <div class="card-body">
                                    @if (isset($owner->data))

                                        @if ($description !== false)
                                            <p>{{ $description }}</p>
                                            <hr>
                                        @endif
                                        @if ($country !== false)
                                            <p><i class="las la-home"></i> Vive en <strong>{{ $country }}</strong>
                                            </p>
                                        @endif
                                        @if ($languages !== false)
                                            <p><i class="las la-globe"></i> Mis idiomas {{ $languages }}</p>
                                        @endif
                                        @if ($gender !== false)
                                            <p><i class="las la-users"></i> Mi genero {!! $gender !!}</p>
                                        @endif
                                        @if ($age !== false)
                                            <p><i class="las la-gifts"></i> Tengo {{ $age }} años</p>
                                        @endif
                                    @else
                                        <h5 class="text-center">No disponible :(</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($photos->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Fotos @if ($owner->data)
                                    ({{ $owner->data->user->photosCount }})
                                @endif
                            </h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p class="m-0"><a href="{{ route('owner.albums', $owner->username) }}">Ver Albums</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                            @foreach ($photos as $photo)
                                <li class="feed-bg-lists container-overlay">
                                    <img src="{{ $photo->urlThumb }}" data-image_vh="{{ $photo->url }}"
                                        alt="gallary-image" class="img-fluid _overlay fullviewer" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if ($videos->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Videos @if ($owner->data)
                                    ({{ $owner->data->user->videosCount }})
                                @endif
                            </h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p class="m-0"><a href="{{ route('owner.videos', $owner->username) }}">Ver Videos</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                            @foreach ($videos as $video)
                                <li class="feed-bg-lists container-overlay">
                                    <img src="{{ $video->coverUrl }}" alt="gallary-image" class="img-fluid _overlay"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="{{ $video->title }}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-8">
            <div id="post-modal-data" class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Crear Post</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="user-img">
                            <img src="{{ URL::to('/') . auth()->guard('customer')->user()->avatar }}" alt="userimg"
                                class="avatar-60 rounded-circle">
                        </div>
                        <form class="post-text ms-3 w-100 " data-bs-toggle="modal" data-bs-target="#post-modal"
                            action="#">
                            <input type="text" class="form-control rounded" placeholder="Escribe algo aquí..."
                                style="border:none;">
                        </form>
                    </div>
                    <hr>
                    <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
                        <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3 mb-md-0 mb-2">
                            <img src="{{ asset('/images/small/07.png') }}" alt="icon" class="img-fluid me-2">
                            Foto/Video
                        </li>
                        <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3 mb-md-0 mb-2">
                            <img src="{{ asset('/images/small/08.png') }}" alt="icon" class="img-fluid me-2">
                            Mencioa un amigo
                        </li>
                        <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3">
                            <img src="{{ asset('/images/small/09.png') }}" alt="icon" class="img-fluid me-2">
                            Estado/Actividad
                        </li>
                        {{-- <li class="bg-soft-primary rounded p-2 pointer text-center">
                            <div class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <div class="dropdown-toggle" id="post-option" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill h4"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="post-option"
                                        style="">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#post-modal">Check in</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#post-modal">Live Video</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#post-modal">Gif</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#post-modal">Watch Party</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#post-modal">Play with Friend</a>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                    </ul>
                </div>
                <div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="post-modalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog  modal-lg modal-fullscreen-sm-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="post-modalLabel">Create Post</h5>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                        class="ri-close-fill"></i></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center">
                                    <div class="user-img">
                                        <img src="{{ asset('/images/user/1.jpg') }}" alt="userimg"
                                            class="avatar-60 rounded-circle img-fluid">
                                    </div>
                                    <form class="post-text ms-3 w-100" action="#">
                                        <input type="text" class="form-control rounded"
                                            placeholder="Write something here..." style="border:none;">
                                    </form>
                                </div>
                                <hr>
                                <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/07.png') }}"
                                                alt="icon" class="img-fluid"> Photo/Video
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/08.png') }}"
                                                alt="icon" class="img-fluid"> Tag Friend
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/09.png') }}"
                                                alt="icon" class="img-fluid">
                                            Feeling/Activity
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/10.png') }}"
                                                alt="icon" class="img-fluid"> Check in
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/11.png') }}"
                                                alt="icon" class="img-fluid"> Live Video
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/12.png') }}"
                                                alt="icon" class="img-fluid"> Gif
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/13.png') }}"
                                                alt="icon" class="img-fluid"> Watch Party
                                        </div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                        <div class="bg-soft-primary rounded p-2 pointer me-3">
                                            <a href="#"></a><img src="{{ asset('/images/small/14.png') }}"
                                                alt="icon" class="img-fluid"> Play with
                                            Friends
                                        </div>
                                    </li>
                                </ul>
                                <hr>
                                <div class="other-option">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="user-img me-3">
                                                <img src="{{ asset('/images/user/1.jpg') }}" alt="userimg"
                                                    class="avatar-60 rounded-circle img-fluid">
                                            </div>
                                            <h6>Your Story</h6>
                                        </div>
                                        <div class="card-post-toolbar">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <span class="btn btn-primary">Friend</span>
                                                </span>
                                                <div class="dropdown-menu m-0 p-0">
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-save-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Public</h6>
                                                                <p class="mb-0">Anyone on or
                                                                    off Facebook</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-close-circle-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Friends</h6>
                                                                <p class="mb-0">Your Friend
                                                                    on facebook</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-user-unfollow-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Friends except</h6>
                                                                <p class="mb-0">Don't show to
                                                                    some friends</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-notification-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Only Me</h6>
                                                                <p class="mb-0">Only me</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary d-block w-100 mt-3">Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($feeds as $feed)
                @include('components.feed', ['feed' => $feed])
            @endforeach

            @if ($feeds->count() % 12 == 0 && $feeds->count() !==0)
                    <button type="submit" class="btn btn-primary d-block w-100 mt-3" wire:click="loadMore">Cargar mas publicaciones</button>
                </div>
            @endif
        </div>
    </div>
</div>
