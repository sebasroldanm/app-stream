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
                            <p class="m-0"><a href="javascript:void(0);">Ver Albums</a></p>
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
                            <p class="m-0"><a href="javascript:void(0);">Ver Videos</a></p>
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
                @if (
                    $feed->type === 'offlineStatusChanged' ||
                        (($feed->type !== 'offlineStatusChanged' && $feed->postFeed->count() > 0) ||
                            $feed->albumFeed->count() > 0 ||
                            $feed->videoFeed->count() > 0))
                    <div class="card">
                        <div class="card-body">
                            <div class="post-item">
                                <div class="user-post-data pb-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="me-3">
                                            <img class="rounded-circle  avatar-60" src="{{ $owner->avatar }}"
                                                alt="">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between flex-wrap">
                                                <div class="">
                                                    <h5 class="mb-0 d-inline-block"><a href="#"
                                                            class="">{{ $owner->username }}</a></h5>
                                                    <p class="ms-1 mb-0 d-inline-block">
                                                        @switch($feed->type)
                                                            @case('postAdded')
                                                                Nueva publicación
                                                            @break

                                                            @case('albumUpdated')
                                                                Album actualizado
                                                            @break

                                                            @case('videoAdded')
                                                                Nuevo video
                                                            @break

                                                            @default
                                                                Nuevo estado
                                                        @endswitch
                                                    </p>
                                                    <p class="mb-0" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-original-title="{{ Carbon\Carbon::parse($feed->updatedAt)->format('d M, Y - H:i:s') }}">
                                                        {{ \Carbon\Carbon::parse($feed->updatedAt)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <code>{{ $feed->id }}</code> --}}

                                {{-- {{ dd($feed) }} --}}

                                @if ($feed->type == 'offlineStatusChanged')
                                    <div class="user-post">
                                        <h5 class="text-center my-5">{{ json_decode($feed->data)->data->offlineStatus }}</h5>
                                    </div>
                                @else
                                    @foreach ($feed->postFeed as $pst)
                                        <div class="user-post">
                                            @if (!empty($pst->body))
                                                <p>{{ $pst->body }}</p>
                                            @endif
                                            <div class="row">
                                                @foreach ($pst->mediaPostFeeds as $media)
                                                    @switch($pst->mediaPostFeeds->count())
                                                        @case(1)
                                                            <div class="col-lg-12 text-center">
                                                                <img src="{{ $media->url }}"
                                                                    class="img-fluid rounded fullviewer max-vh-60"
                                                                    alt="{{ $pst->body }}">
                                                            </div>
                                                        @break

                                                        @case(2)
                                                            <div class="col-lg-6 container-overlay">
                                                                <img src="{{ $media->url }}"
                                                                    class="img-fluid rounded fullviewer max-vh-60 _overlay"
                                                                    alt="{{ $pst->body }}">
                                                            </div>
                                                        @break

                                                        @default
                                                            <div class="col-lg-4 mb-2">
                                                                <img src="{{ $media->url }}"
                                                                    class="img-fluid rounded fullviewer max-vh-60"
                                                                    alt="{{ $pst->body }}">
                                                            </div>
                                                        @break
                                                    @endswitch
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="comment-area mt-3">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="like-block position-relative d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="like-data">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    <img src="{{ asset('/images/icon/01.png') }}"
                                                                        class="img-fluid" alt="">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="total-like-block ms-2 me-3">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    {{ $pst->likes }} Likes
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @foreach ($feed->albumFeed as $album)
                                        <div class="user-post">
                                            @if (!empty($album->name))
                                                <p>{{ $album->name }}</p>
                                            @endif
                                            <div
                                                class="row @if ($feed->accessMode !== 'free') justify-content-center @endif">
                                                @foreach ($album->photos as $photo)
                                                    @if ($feed->accessMode == 'free')
                                                        @switch($album->photosCount)
                                                            @case(1)
                                                                <div class="col-lg-12 text-center">
                                                                    <img src="{{ $photo->url }}"
                                                                        class="img-fluid rounded fullviewer max-vh-60"
                                                                        alt="{{ $album->body }}">
                                                                </div>
                                                            @break

                                                            @case(2)
                                                                <div class="col-lg-6 container-overlay">
                                                                    <img src="{{ $photo->url }}"
                                                                        class="img-fluid rounded fullviewer max-vh-60 _overlay"
                                                                        alt="{{ $album->body }}">
                                                                </div>
                                                            @break

                                                            @default
                                                                <div class="col-lg-4 mb-2 container-overlay">
                                                                    <img src="{{ $photo->urlThumb }}"
                                                                        data-image_vh="{{ $photo->url }}"
                                                                        class="img-fluid rounded fullviewer max-vh-60 _overlay"
                                                                        alt="{{ $album->body }}">
                                                                </div>
                                                            @break
                                                        @endswitch
                                                    @else
                                                        @if ($photo->url)
                                                            <div class="col-lg-12 text-center">
                                                                <img src="{{ $photo->url }}"
                                                                    class="img-fluid rounded fullviewer max-vh-60"
                                                                    alt="{{ $album->body }}">
                                                            </div>
                                                        @else
                                                            <div class="col-2 my-2 container-overlay rounded">
                                                                <img src="{{ $photo->urlThumbMicro }}"
                                                                    class="img-fluid w-100 _overlay filter_blur_10"
                                                                    alt="{{ $album->body }}">
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="comment-area mt-3">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="like-block position-relative d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="like-data">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    <img src="{{ asset('/images/icon/01.png') }}"
                                                                        class="img-fluid" alt="">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="total-like-block ms-2 me-3">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    {{ $album->likes }} Likes
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- {{dd($feed)}} --}}
                                    @foreach ($feed->videoFeed as $video)
                                        <div class="user-post">
                                            @if (!empty($video->title))
                                                <p>{{ $video->title }}</p>
                                            @endif
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <video class="video_feed" data-poster="{{ $video->coverUrl }}"
                                                        @if ($video->videoUrl) data-video="{{ $video->videoUrl }}"
                                                    data-format="{{ $video->format_video }}"
                                                @else
                                                    data-video="{{ $video->trailerUrl }}"
                                                    data-format="{{ $video->format_trailer }}" @endif>
                                                    </video>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="comment-area mt-3">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="like-block position-relative d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="like-data">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    <img src="{{ asset('/images/icon/01.png') }}"
                                                                        class="img-fluid" alt="">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="total-like-block ms-2 me-3">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    {{ $video->likes }} Likes
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @if ($feeds->count() % 12 == 0 && $feeds->count() !==0)
                    <button type="submit" class="btn btn-primary d-block w-100 mt-3" wire:click="loadMore">Cargar mas publicaciones</button>
                </div>
            @endif
        </div>
    </div>
</div>
