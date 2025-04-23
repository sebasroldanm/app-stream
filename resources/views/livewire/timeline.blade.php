<div>
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 row m-0 p-0">
                    <div class="col-sm-12">
                        <div id="post-modal-data" class="card card-block card-stretch card-height">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Crear Post</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="user-img">
                                        <img src="{{ URL::to("/") . auth()->guard('customer')->user()->avatar }}" alt="userimg"
                                            class="avatar-60 rounded-circle">
                                    </div>
                                    <form class="post-text ms-3 w-100 " data-bs-toggle="modal"
                                        data-bs-target="#post-modal" action="javascript:void();">
                                        <input type="text" class="form-control rounded"
                                            placeholder="Write something here..." style="border:none;">
                                    </form>
                                </div>
                                <hr>
                                <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
                                    <li class="me-3 mb-md-0 mb-2">
                                        <a href="#" class="btn btn-soft-primary">
                                            <img src="{{ asset('/images/small/07.png') }}" alt="icon"
                                                class="img-fluid me-2"> Photo/Video
                                        </a>
                                    </li>
                                    <li class="me-3 mb-md-0 mb-2">
                                        <a href="#" class="btn btn-soft-primary">
                                            <img src="{{ asset('/images/small/08.png') }}" alt="icon"
                                                class="img-fluid me-2"> Tag Friend
                                        </a>
                                    </li>
                                    <li class="me-3">
                                        <a href="#" class="btn btn-soft-primary">
                                            <img src="{{ asset('/images/small/09.png') }}" alt="icon"
                                                class="img-fluid me-2"> Feeling/Activity
                                        </a>
                                    </li>
                                    <li>
                                        <button class="btn btn-soft-primary">
                                            <div class="card-header-toolbar d-flex align-items-center">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" id="post-option"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ri-more-fill"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="post-option" style="">
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
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="post-modalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog   modal-fullscreen-sm-down">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="post-modalLabel">Crear Post</h5>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                                    class="ri-close-fill"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex align-items-center">
                                                <div class="user-img">
                                                    <img src="{{ URL::to("/") . auth()->guard('customer')->user()->avatar }}" alt="userimg"
                                                        class="avatar-60 rounded-circle img-fluid">
                                                </div>
                                                <form class="post-text ms-3 w-100" action="javascript:void();">
                                                    <input type="text" class="form-control rounded"
                                                        placeholder="Write something here..." style="border:none;">
                                                </form>
                                            </div>
                                            <hr>
                                            <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/07.png') }}" alt="icon"
                                                            class="img-fluid"> Photo/Video</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/08.png') }}" alt="icon"
                                                            class="img-fluid"> Tag Friend</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/09.png') }}" alt="icon"
                                                            class="img-fluid"> Feeling/Activity</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/10.png') }}" alt="icon"
                                                            class="img-fluid"> Check in</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/11.png') }}" alt="icon"
                                                            class="img-fluid"> Live Video</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/12.png') }}" alt="icon"
                                                            class="img-fluid"> Gif</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/13.png') }}" alt="icon"
                                                            class="img-fluid"> Watch Party</div>
                                                </li>
                                                <li class="col-md-6 mb-3">
                                                    <div class="bg-soft-primary rounded p-2 pointer me-3"><a
                                                            href="#"></a><img
                                                            src="{{ asset('/images/small/14.png') }}" alt="icon"
                                                            class="img-fluid"> Play with Friends</div>
                                                </li>
                                            </ul>
                                            <hr>
                                            <div class="other-option">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-img me-3">
                                                            <img src="{{ URL::to("/") . auth()->guard('customer')->user()->avatar }}"
                                                                alt="userimg"
                                                                class="avatar-60 rounded-circle img-fluid">
                                                        </div>
                                                        <h6>Tu Historia</h6>
                                                    </div>
                                                    <div class="card-post-toolbar">
                                                        <div class="dropdown">
                                                            <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                role="button">
                                                                <span class="btn btn-primary">Friend</span>
                                                            </span>
                                                            <div class="dropdown-menu m-0 p-0">
                                                                <a class="dropdown-item p-3" href="#">
                                                                    <div class="d-flex align-items-top">
                                                                        <i class="ri-save-line h4"></i>
                                                                        <div class="data ms-2">
                                                                            <h6>Public</h6>
                                                                            <p class="mb-0">Anyone on or off Facebook
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="dropdown-item p-3" href="#">
                                                                    <div class="d-flex align-items-top">
                                                                        <i class="ri-close-circle-line h4"></i>
                                                                        <div class="data ms-2">
                                                                            <h6>Friends</h6>
                                                                            <p class="mb-0">Your Friend on facebook
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="dropdown-item p-3" href="#">
                                                                    <div class="d-flex align-items-top">
                                                                        <i class="ri-user-unfollow-line h4"></i>
                                                                        <div class="data ms-2">
                                                                            <h6>Friends except</h6>
                                                                            <p class="mb-0">Don't show to some
                                                                                friends</p>
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
                                            <button type="submit"
                                                class="btn btn-primary d-block w-100 mt-3">Post</button>
                                        </div>
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
                            <div class="col-sm-12">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body">
                                        <div class="user-post-data" data-id="{{ $feed->id }}">
                                            <div class="d-flex justify-content-between">
                                                <div class="me-3">
                                                    <a href="{{ route('view.owner', $feed->owner->username) }}" wire:navigate>
                                                        <img class="avatar-60 rounded-circle"
                                                            src="{{ $feed->owner->avatar }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="w-100">
                                                    <div class=" d-flex  justify-content-between">
                                                        <div class="">
                                                            <a href="{{ route('view.owner', $feed->owner->username) }}" wire:navigate>
                                                                <h5 class="mb-0 d-inline-block">
                                                                    {{ $feed->owner->username }}</h5>
                                                            </a>
                                                            <p class="mb-0 d-inline-block">
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
                                                            <p class="mb-0 text-primary" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                data-bs-original-title="{{ Carbon\Carbon::parse($feed->updatedAt)->format('d M, Y - H:i:s') }}">
                                                                {{ \Carbon\Carbon::parse($feed->updatedAt)->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                        <div class="card-post-toolbar">
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" role="button">
                                                                    <i class="ri-more-fill"></i>
                                                                </span>
                                                                <div class="dropdown-menu m-0 p-0">
                                                                    <a class="dropdown-item p-3" href="#">
                                                                        <div class="d-flex align-items-top">
                                                                            <i class="ri-save-line h4"></i>
                                                                            <div class="data ms-2">
                                                                                <h6>Save Post</h6>
                                                                                <p class="mb-0">Add this to your
                                                                                    saved items
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <a class="dropdown-item p-3" href="#">
                                                                        <div class="d-flex align-items-top">
                                                                            <i class="ri-close-circle-line h4"></i>
                                                                            <div class="data ms-2">
                                                                                <h6>Hide Post</h6>
                                                                                <p class="mb-0">See fewer posts like
                                                                                    this.
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <a class="dropdown-item p-3" href="#">
                                                                        <div class="d-flex align-items-top">
                                                                            <i class="ri-user-unfollow-line h4"></i>
                                                                            <div class="data ms-2">
                                                                                <h6>Unfollow User</h6>
                                                                                <p class="mb-0">Stop seeing posts but
                                                                                    stay
                                                                                    friends.</p>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <a class="dropdown-item p-3" href="#">
                                                                        <div class="d-flex align-items-top">
                                                                            <i class="ri-notification-line h4"></i>
                                                                            <div class="data ms-2">
                                                                                <h6>Notifications</h6>
                                                                                <p class="mb-0">Turn on notifications
                                                                                    for
                                                                                    this post</p>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            @if ($feed->type == 'offlineStatusChanged')
                                                <h5 class="text-center my-5">
                                                    {{ json_decode($feed->data)->data->offlineStatus }}
                                                </h5>
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
                                                                                class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                                                                alt="{{ $pst->body }}">
                                                                        </div>
                                                                    @break

                                                                    @case(3)
                                                                        <div class="col-lg-4 mb-2 container-overlay">
                                                                            <img src="{{ $media->url }}"
                                                                                class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
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
                                                                                    class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                                                                    alt="{{ $album->body }}">
                                                                            </div>
                                                                        @break

                                                                        @default
                                                                            <div class="col-lg-4 mb-2 container-overlay">
                                                                                <img src="{{ $photo->urlThumb }}"
                                                                                    data-image_vh="{{ $photo->url }}"
                                                                                    class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
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
                                                                        <div
                                                                            class="col-2 my-2 container-overlay rounded">
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
                                                        <div
                                                            class="d-flex justify-content-between align-items-center flex-wrap">
                                                            <div
                                                                class="like-block position-relative d-flex align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    {{-- <div class="like-data">
                                                                        <div class="dropdown">
                                                                            <span class="dropdown-toggle"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false" role="button">
                                                                                <img src="{{ asset('/images/icon/01.png') }}"
                                                                                    class="img-fluid" alt="">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="total-like-block ms-2 me-3">
                                                                        <div class="dropdown">
                                                                            <span class="dropdown-toggle"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false" role="button">
                                                                                {{ $album->likes }} Likes
                                                                            </span>
                                                                        </div>
                                                                    </div> --}}
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
                                                                <video class="video_feed"
                                                                    data-poster="{{ $video->coverUrl }}"
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
                                                        <div
                                                            class="d-flex justify-content-between align-items-center flex-wrap">
                                                            <div
                                                                class="like-block position-relative d-flex align-items-center">
                                                                {{-- <div class="d-flex align-items-center">
                                                                    <div class="like-data">
                                                                        <div class="dropdown">
                                                                            <span class="dropdown-toggle"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false" role="button">
                                                                                <img src="{{ asset('/images/icon/01.png') }}"
                                                                                    class="img-fluid" alt="">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="total-like-block ms-2 me-3">
                                                                        <div class="dropdown">
                                                                            <span class="dropdown-toggle"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false" role="button">
                                                                                {{ $video->likes }} Likes
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
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
                                                                    {{-- {{ $pst->likes }} Likes --}}
                                                                    00 Likes
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>

                <div class="col-lg-4">
                    {{-- <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Stories</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                <li class="d-flex mb-3 align-items-center">
                                    <i class="ri-add-line"></i>
                                    <div class="stories-data ms-3">
                                        <h5>Creat Your Story</h5>
                                        <p class="mb-0">time to story</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-3 align-items-center active">
                                    <img src="{{ asset('/images/page-img/s2.jpg') }}" alt="story-img"
                                        class="rounded-circle img-fluid">
                                    <div class="stories-data ms-3">
                                        <h5>Anna Mull</h5>
                                        <p class="mb-0">1 hour ago</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-3 align-items-center">
                                    <img src="{{ asset('/images/page-img/s3.jpg') }}" alt="story-img"
                                        class="rounded-circle img-fluid">
                                    <div class="stories-data ms-3">
                                        <h5>Ira Membrit</h5>
                                        <p class="mb-0">4 hour ago</p>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <img src="{{ asset('/images/page-img/s1.jpg') }}" alt="story-img"
                                        class="rounded-circle img-fluid">
                                    <div class="stories-data ms-3">
                                        <h5>Bob Frapples</h5>
                                        <p class="mb-0">9 hour ago</p>
                                    </div>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary d-block mt-3">See All</a>
                        </div>
                    </div> --}}
                    {{-- <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Events</h4>
                            </div>
                            <div class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <div class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" role="button">
                                        <i class="ri-more-fill h4"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton" style="">
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-eye-fill me-2"></i>View</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-delete-bin-6-fill me-2"></i>Delete</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-pencil-fill me-2"></i>Edit</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-printer-fill me-2"></i>Print</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-file-download-fill me-2"></i>Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                <li class="d-flex mb-4 align-items-center ">
                                    <img src="{{ asset('/images/page-img/s4.jpg') }}" alt="story-img"
                                        class="rounded-circle img-fluid">
                                    <div class="stories-data ms-3">
                                        <h5>Web Workshop</h5>
                                        <p class="mb-0">1 hour ago</p>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <img src="{{ asset('/images/page-img/s5.jpg') }}" alt="story-img"
                                        class="rounded-circle img-fluid">
                                    <div class="stories-data ms-3">
                                        <h5>Fun Events and Festivals</h5>
                                        <p class="mb-0">1 hour ago</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Favoritos</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                @foreach ($owner_fav as $own_fav)
                                    <li class="d-flex mb-4 align-items-center">
                                        <img src="{{ $own_fav->avatar }}" alt="story-img"
                                            class="rounded-circle img-fluid">
                                        <div class="stories-data ms-3">
                                            <h5>{{ $own_fav->username }}</h5>
                                            <p class="mb-0">{{ \Carbon\Carbon::parse($own_fav->statusChangedAt)->diffForHumans() }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Próximo cumpleaños</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                @foreach ($owner_birthday as $ownr_b)
                                    <li class="d-flex mb-4 align-items-center">
                                        <img src="{{ $ownr_b->avatar }}" alt="story-img"
                                            class="rounded-circle img-fluid">
                                        <div class="stories-data ms-3">
                                            <h5>{{ $ownr_b->username }}</h5>
                                            @php
                                                $birthday = \Carbon\Carbon::parse(json_decode($ownr_b->data)->user->user->birthDate)->format('d/m');
                                            @endphp
                                            <p class="mb-0">{{ $birthday }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Suggested Pages</h4>
                            </div>
                            <div class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <div class="dropdown-toggle" id="dropdownMenuButton01" data-bs-toggle="dropdown"
                                        aria-expanded="false" role="button">
                                        <i class="ri-more-fill h4"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton01">
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-eye-fill me-2"></i>View</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-delete-bin-6-fill me-2"></i>Delete</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-pencil-fill me-2"></i>Edit</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-printer-fill me-2"></i>Print</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ri-file-download-fill me-2"></i>Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="suggested-page-story m-0 p-0 list-inline">
                                <li class="mb-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('/images/page-img/42.png') }}" alt="story-img"
                                            class="rounded-circle img-fluid avatar-50">
                                        <div class="stories-data ms-3">
                                            <h5>Iqonic Studio</h5>
                                            <p class="mb-0">Lorem Ipsum</p>
                                        </div>
                                    </div>
                                    <img src="{{ asset('/images/small/img-1.jpg') }}" class="img-fluid rounded"
                                        alt="Responsive image">
                                    <div class="mt-3"><a href="#" class="btn d-block"><i
                                                class="ri-thumb-up-line me-2"></i> Like Page</a></div>
                                </li>
                                <li class="">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('/images/page-img/42.png') }}" alt="story-img"
                                            class="rounded-circle img-fluid avatar-50">
                                        <div class="stories-data ms-3">
                                            <h5>Cakes &amp; Bakes </h5>
                                            <p class="mb-0">Lorem Ipsum</p>
                                        </div>
                                    </div>
                                    <img src="{{ asset('/images/small/img-2.jpg') }}" class="img-fluid rounded"
                                        alt="Responsive image">
                                    <div class="mt-3"><a href="#" class="btn d-block"><i
                                                class="ri-thumb-up-line me-2"></i> Like Page</a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
