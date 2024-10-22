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
                            <h4 class="card-title">Fotos ({{ $owner->data->user->photosCount }})</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p class="m-0"><a href="#">Ver Albums</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                            @foreach ($photos as $photo)
                                <li class="feed-bg-lists container-overlay">
                                    <a href="#">
                                        <img src="{{ $photo->url }}" alt="gallary-image" class="img-fluid _overlay" />
                                    </a>
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
                            <h4 class="card-title">Videos ({{ $owner->data->user->videosCount }})</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p class="m-0"><a href="#">Ver Videos</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                            @foreach ($videos as $video)
                                <li class="feed-bg-lists container-overlay">
                                    <a href="#">
                                        <img src="{{ $video->coverUrl }}" alt="gallary-image" class="img-fluid _overlay"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="{{ $video->title }}" />
                                    </a>
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
                            <img src="{{ URL::to("/") . auth()->guard('customer')->user()->avatar }}" alt="userimg"
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
            <div class="card">
                <div class="card-body">
                    <div class="post-item">
                        <div class="user-post-data pb-3">
                            <div class="d-flex justify-content-between">
                                <div class="me-3">
                                    <img class="rounded-circle  avatar-60" src="{{ asset('/images/user/1.jpg') }}"
                                        alt="">
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div class="">
                                            <h5 class="mb-0 d-inline-block"><a href="#" class="">Bni
                                                    Cyst</a></h5>
                                            <p class="ms-1 mb-0 d-inline-block">Add New Post
                                            </p>
                                            <p class="mb-0">3 hour ago</p>
                                        </div>
                                        <div class="card-post-toolbar">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu m-0 p-0">
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-save-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Save Post</h6>
                                                                <p class="mb-0">Add this to
                                                                    your saved items</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-pencil-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Edit Post</h6>
                                                                <p class="mb-0">Update your
                                                                    post and saved items
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-close-circle-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Hide From Timeline</h6>
                                                                <p class="mb-0">See fewer
                                                                    posts like this.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-delete-bin-7-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Delete</h6>
                                                                <p class="mb-0">Remove thids
                                                                    Post on Timeline
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-notification-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Notifications</h6>
                                                                <p class="mb-0">Turn on
                                                                    notifications for this
                                                                    post</p>
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
                        <div class="user-post">
                            <a href="#"><img src="{{ asset('/images/page-img/p1.jpg') }}" alt="post-image"
                                    class="img-fluid w-100" /></a>
                        </div>
                        <div class="comment-area mt-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="like-block position-relative d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="like-data">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <img src="{{ asset('/images/icon/01.png') }}" class="img-fluid"
                                                        alt="">
                                                </span>
                                                <div class="dropdown-menu py-2">
                                                    <a class="ms-2 me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Like"><img
                                                            src="{{ asset('/images/icon/01.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Love"><img
                                                            src="{{ asset('/images/icon/02.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Happy"><img
                                                            src="{{ asset('/images/icon/03.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="HaHa"><img
                                                            src="{{ asset('/images/icon/04.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Think"><img
                                                            src="{{ asset('/images/icon/05.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Sade"><img
                                                            src="{{ asset('/images/icon/06.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Lovely"><img
                                                            src="{{ asset('/images/icon/07.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total-like-block ms-2 me-3">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    140 Likes
                                                </span>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Max Emum</a>
                                                    <a class="dropdown-item" href="#">Bill Yerds</a>
                                                    <a class="dropdown-item" href="#">Hap E. Birthday</a>
                                                    <a class="dropdown-item" href="#">Tara Misu</a>
                                                    <a class="dropdown-item" href="#">Midge Itz</a>
                                                    <a class="dropdown-item" href="#">Sal Vidge</a>
                                                    <a class="dropdown-item" href="#">Other</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="total-comment-block">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" role="button">
                                                20 Comment
                                            </span>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Max
                                                    Emum</a>
                                                <a class="dropdown-item" href="#">Bill
                                                    Yerds</a>
                                                <a class="dropdown-item" href="#">Hap E.
                                                    Birthday</a>
                                                <a class="dropdown-item" href="#">Tara
                                                    Misu</a>
                                                <a class="dropdown-item" href="#">Midge
                                                    Itz</a>
                                                <a class="dropdown-item" href="#">Sal
                                                    Vidge</a>
                                                <a class="dropdown-item" href="#">Other</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#share-btn"
                                        aria-controls="share-btn"><i class="ri-share-line"></i>
                                        <span class="ms-1">99 Share</span></a>
                                </div>
                            </div>
                            <hr>
                            <ul class="post-comments p-0 m-0">
                                <li class="mb-2">
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/02.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Monty Carlo</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/03.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Paul Molive</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                                <input type="text" class="form-control rounded" placeholder="Enter Your Comment">
                                <div class="comment-attagement d-flex">
                                    <a href="#"><i class="ri-link me-3"></i></a>
                                    <a href="#"><i class="ri-user-smile-line me-3"></i></a>
                                    <a href="#"><i class="ri-camera-line me-3"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="post-item">
                        <div class="user-post-data py-3">
                            <div class="d-flex  justify-content-between">
                                <div class="me-3">
                                    <img class="rounded-circle  avatar-60" src="{{ asset('/images/user/1.jpg') }}"
                                        alt="">
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <h5 class="mb-0 d-inline-block me-1"><a href="#" class="">Bni
                                                    Cyst</a></h5>
                                            <p class="mb-0 d-inline-block">Share Anna Mull's
                                                Post</p>
                                            <p class="mb-0">5 hour ago</p>
                                        </div>
                                        <div class="card-post-toolbar">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu m-0 p-0">
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-save-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Save Post</h6>
                                                                <p class="mb-0">Add this to
                                                                    your saved items</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-pencil-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Edit Post</h6>
                                                                <p class="mb-0">Update your
                                                                    post and saved items
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-close-circle-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Hide From Timeline</h6>
                                                                <p class="mb-0">See fewer
                                                                    posts like this.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-delete-bin-7-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Delete</h6>
                                                                <p class="mb-0">Remove thids
                                                                    Post on Timeline
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-notification-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Notifications</h6>
                                                                <p class="mb-0">Turn on
                                                                    notifications for this
                                                                    post</p>
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
                        <div class="user-post">
                            <a href="#"><img src="{{ asset('/images/page-img/p3.jpg') }}" alt="post-image"
                                    class="img-fluid w-100" /></a>
                        </div>
                        <div class="comment-area mt-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="like-block position-relative d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="like-data">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <img src="{{ asset('/images/icon/01.png') }}" class="img-fluid"
                                                        alt="">
                                                </span>
                                                <div class="dropdown-menu py-2">
                                                    <a class="ms-2 me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Like"><img
                                                            src="{{ asset('/images/icon/01.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Love"><img
                                                            src="{{ asset('/images/icon/02.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Happy"><img
                                                            src="{{ asset('/images/icon/03.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="HaHa"><img
                                                            src="{{ asset('/images/icon/04.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Think"><img
                                                            src="{{ asset('/images/icon/05.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Sade"><img
                                                            src="{{ asset('/images/icon/06.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Lovely"><img
                                                            src="{{ asset('/images/icon/07.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total-like-block ms-2 me-3">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    140 Likes
                                                </span>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Max Emum</a>
                                                    <a class="dropdown-item" href="#">Bill Yerds</a>
                                                    <a class="dropdown-item" href="#">Hap E. Birthday</a>
                                                    <a class="dropdown-item" href="#">Tara Misu</a>
                                                    <a class="dropdown-item" href="#">Midge Itz</a>
                                                    <a class="dropdown-item" href="#">Sal Vidge</a>
                                                    <a class="dropdown-item" href="#">Other</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="total-comment-block">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" role="button">
                                                20 Comment
                                            </span>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Max
                                                    Emum</a>
                                                <a class="dropdown-item" href="#">Bill
                                                    Yerds</a>
                                                <a class="dropdown-item" href="#">Hap E.
                                                    Birthday</a>
                                                <a class="dropdown-item" href="#">Tara
                                                    Misu</a>
                                                <a class="dropdown-item" href="#">Midge
                                                    Itz</a>
                                                <a class="dropdown-item" href="#">Sal
                                                    Vidge</a>
                                                <a class="dropdown-item" href="#">Other</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#share-btn"
                                        aria-controls="share-btn"><i class="ri-share-line"></i>
                                        <span class="ms-1">99 Share</span></a>
                                </div>
                            </div>
                            <hr>
                            <ul class="post-comments p-0 m-0">
                                <li class="mb-2">
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/02.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Monty Carlo</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/03.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Paul Molive</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                                <input type="text" class="form-control rounded" placeholder="Enter Your Comment">
                                <div class="comment-attagement d-flex">
                                    <a href="#"><i class="ri-link me-3"></i></a>
                                    <a href="#"><i class="ri-user-smile-line me-3"></i></a>
                                    <a href="#"><i class="ri-camera-line me-3"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="post-item">
                        <div class="user-post-data py-3">
                            <div class="d-flex justify-content-between">
                                <div class="me-3">
                                    <img class="rounded-circle avatar-60" src="{{ asset('/images/user/1.jpg') }}"
                                        alt="">
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <h5 class="mb-0 d-inline-block"><a href="#" class="">Bni
                                                    Cyst</a></h5>
                                            <p class="ms-1 mb-0 d-inline-block">Update his
                                                Status</p>
                                            <p class="mb-0">7 hour ago</p>
                                        </div>
                                        <div class="card-post-toolbar">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu m-0 p-0">
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-save-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Save Post</h6>
                                                                <p class="mb-0">Add this to
                                                                    your saved items</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-pencil-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Edit Post</h6>
                                                                <p class="mb-0">Update your
                                                                    post and saved items
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-close-circle-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Hide From Timeline</h6>
                                                                <p class="mb-0">See fewer
                                                                    posts like this.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-delete-bin-7-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Delete</h6>
                                                                <p class="mb-0">Remove thids
                                                                    Post on Timeline
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-notification-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Notifications</h6>
                                                                <p class="mb-0">Turn on
                                                                    notifications for this
                                                                    post</p>
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
                        <div class="user-post">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum has been the industry's standard dummy
                                text ever
                                since the 1500s, when an unknown printer took a galley of type
                                and
                                scrambled it to make a type specimen book. It has survived not
                                only five
                                centuries,</p>
                        </div>
                        <div class="comment-area mt-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="like-block position-relative d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="like-data">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <img src="{{ asset('/images/icon/01.png') }}" class="img-fluid"
                                                        alt="">
                                                </span>
                                                <div class="dropdown-menu py-2">
                                                    <a class="ms-2 me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Like"><img
                                                            src="{{ asset('/images/icon/01.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Love"><img
                                                            src="{{ asset('/images/icon/02.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Happy"><img
                                                            src="{{ asset('/images/icon/03.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="HaHa"><img
                                                            src="{{ asset('/images/icon/04.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Think"><img
                                                            src="{{ asset('/images/icon/05.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Sade"><img
                                                            src="{{ asset('/images/icon/06.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Lovely"><img
                                                            src="{{ asset('/images/icon/07.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total-like-block ms-2 me-3">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    140 Likes
                                                </span>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Max Emum</a>
                                                    <a class="dropdown-item" href="#">Bill Yerds</a>
                                                    <a class="dropdown-item" href="#">Hap E. Birthday</a>
                                                    <a class="dropdown-item" href="#">Tara Misu</a>
                                                    <a class="dropdown-item" href="#">Midge Itz</a>
                                                    <a class="dropdown-item" href="#">Sal Vidge</a>
                                                    <a class="dropdown-item" href="#">Other</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="total-comment-block">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" role="button">
                                                20 Comment
                                            </span>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Max
                                                    Emum</a>
                                                <a class="dropdown-item" href="#">Bill
                                                    Yerds</a>
                                                <a class="dropdown-item" href="#">Hap
                                                    E. Birthday</a>
                                                <a class="dropdown-item" href="#">Tara
                                                    Misu</a>
                                                <a class="dropdown-item" href="#">Midge Itz</a>
                                                <a class="dropdown-item" href="#">Sal
                                                    Vidge</a>
                                                <a class="dropdown-item" href="#">Other</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#share-btn"
                                        aria-controls="share-btn"><i class="ri-share-line"></i>
                                        <span class="ms-1">99 Share</span></a>
                                </div>
                            </div>
                            <hr>
                            <ul class="post-comments p-0 m-0">
                                <li class="mb-2">
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/02.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Monty Carlo</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/03.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Paul Molive</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                                <input type="text" class="form-control rounded" placeholder="Enter Your Comment">
                                <div class="comment-attagement d-flex">
                                    <a href="#"><i class="ri-link me-3"></i></a>
                                    <a href="#"><i class="ri-user-smile-line me-3"></i></a>
                                    <a href="#"><i class="ri-camera-line me-3"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="post-item">
                        <div class="user-post-data py-3">
                            <div class="d-flex justify-content-between">
                                <div class=" me-3">
                                    <img class="rounded-circle avatar-60" src="{{ asset('/images/user/1.jpg') }}"
                                        alt="">
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <h5 class="mb-0 d-inline-block me-1"><a href="#" class="">Bni
                                                    Cyst</a></h5>
                                            <p class=" mb-0 d-inline-block">Change Profile
                                                Picture</p>
                                            <p class="mb-0">3 day ago</p>
                                        </div>
                                        <div class="card-post-toolbar">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu m-0 p-0">
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-save-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Save Post</h6>
                                                                <p class="mb-0">Add this to
                                                                    your saved items</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-pencil-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Edit Post</h6>
                                                                <p class="mb-0">Update your
                                                                    post and saved items
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-close-circle-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Hide From Timeline</h6>
                                                                <p class="mb-0">See fewer
                                                                    posts like this.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-delete-bin-7-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Delete</h6>
                                                                <p class="mb-0">Remove thids
                                                                    Post on Timeline
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="dropdown-item p-3" href="#">
                                                        <div class="d-flex align-items-top">
                                                            <i class="ri-notification-line h4"></i>
                                                            <div class="data ms-2">
                                                                <h6>Notifications</h6>
                                                                <p class="mb-0">Turn on
                                                                    notifications for this
                                                                    post</p>
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
                        <div class="user-post text-center">
                            <a href="#"><img src="{{ asset('/images/page-img/p1.jpg') }}" alt="post-image"
                                    class="img-fluid profile-img" /></a>
                        </div>
                        <div class="comment-area mt-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="like-block position-relative d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="like-data">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    <img src="{{ asset('/images/icon/01.png') }}" class="img-fluid"
                                                        alt="">
                                                </span>
                                                <div class="dropdown-menu py-2">
                                                    <a class="ms-2 me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Like"><img
                                                            src="{{ asset('/images/icon/01.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Love"><img
                                                            src="{{ asset('/images/icon/02.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Happy"><img
                                                            src="{{ asset('/images/icon/03.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="HaHa"><img
                                                            src="{{ asset('/images/icon/04.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Think"><img
                                                            src="{{ asset('/images/icon/05.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Sade"><img
                                                            src="{{ asset('/images/icon/06.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                    <a class="me-2" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Lovely"><img
                                                            src="{{ asset('/images/icon/07.png') }}"
                                                            class="img-fluid" alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total-like-block ms-2 me-3">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" role="button">
                                                    140 Likes
                                                </span>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Max Emum</a>
                                                    <a class="dropdown-item" href="#">Bill Yerds</a>
                                                    <a class="dropdown-item" href="#">Hap E. Birthday</a>
                                                    <a class="dropdown-item" href="#">Tara Misu</a>
                                                    <a class="dropdown-item" href="#">Midge Itz</a>
                                                    <a class="dropdown-item" href="#">Sal Vidge</a>
                                                    <a class="dropdown-item" href="#">Other</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="total-comment-block">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" role="button">
                                                20 Comment
                                            </span>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Max
                                                    Emum</a>
                                                <a class="dropdown-item" href="#">Bill
                                                    Yerds</a>
                                                <a class="dropdown-item" href="#">Hap
                                                    E. Birthday</a>
                                                <a class="dropdown-item" href="#">Tara
                                                    Misu</a>
                                                <a class="dropdown-item" href="#">Midge Itz</a>
                                                <a class="dropdown-item" href="#">Sal
                                                    Vidge</a>
                                                <a class="dropdown-item" href="#">Other</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#share-btn"
                                        aria-controls="share-btn"><i class="ri-share-line"></i>
                                        <span class="ms-1">99 Share</span></a>
                                </div>
                            </div>
                            <hr>
                            <ul class="post-comments p-0 m-0">
                                <li class="mb-2">
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/02.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Monty Carlo</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex flex-wrap">
                                        <div class="user-img">
                                            <img src="{{ asset('/images/user/03.jpg') }}" alt="userimg"
                                                class="avatar-35 rounded-circle img-fluid">
                                        </div>
                                        <div class="comment-data-block ms-3">
                                            <h6>Paul Molive</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet</p>
                                            <div class="d-flex flex-wrap align-items-center comment-activity">
                                                <a href="#">like</a>
                                                <a href="#">reply</a>
                                                <a href="#">translate</a>
                                                <span> 5 min </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                                <input type="text" class="form-control rounded"
                                    placeholder="Enter Your Comment">
                                <div class="comment-attagement d-flex">
                                    <a href="#"><i class="ri-link me-3"></i></a>
                                    <a href="#"><i class="ri-user-smile-line me-3"></i></a>
                                    <a href="#"><i class="ri-camera-line me-3"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
