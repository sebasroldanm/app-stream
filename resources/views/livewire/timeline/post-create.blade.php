<div id="post-modal-data" class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">{{ __('owner/feed/posts.create_post') }}</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="user-img">
                <img src="https://ui-avatars.com/api/?name={{ auth()->guard('customer')->user()->username }}&background=fa377b&color=fff"
                    alt="userimg" class="avatar-60 rounded-circle">
            </div>
            <form class="post-text ms-3 w-100 " data-bs-toggle="modal" data-bs-target="#post-modal" action="#">
                <input type="text" class="form-control rounded"
                    placeholder="{{ __('owner/feed/posts.write_something') }}" style="border:none;">
            </form>
        </div>
        <hr>
        <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
            <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3 mb-md-0 mb-2">
                <img src="{{ asset('/images/small/07.png') }}" alt="icon" class="img-fluid me-2">
                {{ __('owner/feed/posts.photo_video') }}
            </li>
            <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3 mb-md-0 mb-2">
                <img src="{{ asset('/images/small/08.png') }}" alt="icon" class="img-fluid me-2">
                {{ __('owner/feed/posts.mention_friend') }}
            </li>
            <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3">
                <img src="{{ asset('/images/small/09.png') }}" alt="icon" class="img-fluid me-2">
                {{ __('owner/feed/posts.status_activity') }}
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
    <div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="post-modalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="post-modalLabel">{{ __('owner/feed/posts.create_post') }}</h5>
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
                                placeholder="{{ __('owner/feed/posts.write_something') }}" style="border:none;">
                        </form>
                    </div>
                    <hr>
                    <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/07.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.photo_video') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/08.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.mention_friend') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/09.png') }}" alt="icon"
                                    class="img-fluid">
                                {{ __('owner/feed/posts.feeling_activity') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/10.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.location') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/11.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.live_video') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/12.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.gif') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/13.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.watch_party') }}
                            </div>
                        </li>
                        <li class="col-md-6 mb-3">
                            <div class="bg-soft-primary rounded p-2 pointer me-3">
                                <a href="#"></a><img src="{{ asset('/images/small/14.png') }}" alt="icon"
                                    class="img-fluid"> {{ __('owner/feed/posts.play_with_friends') }}
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
                                <h6>{{ __('owner/feed/posts.your_story') }}</h6>
                            </div>
                            <div class="card-post-toolbar">
                                <div class="dropdown">
                                    <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" role="button">
                                        <span class="btn btn-primary">{{ __('owner/feed/posts.friends') }}</span>
                                    </span>
                                    <div class="dropdown-menu m-0 p-0">
                                        <a class="dropdown-item p-3" href="#">
                                            <div class="d-flex align-items-top">
                                                <i class="ri-save-line h4"></i>
                                                <div class="data ms-2">
                                                    <h6>{{ __('owner/feed/posts.public') }}</h6>
                                                    <p class="mb-0">
                                                        {{ __('owner/feed/posts.anyone_on_or_off_facebook') }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item p-3" href="#">
                                            <div class="d-flex align-items-top">
                                                <i class="ri-close-circle-line h4"></i>
                                                <div class="data ms-2">
                                                    <h6>{{ __('owner/feed/posts.friends') }}</h6>
                                                    <p class="mb-0">
                                                        {{ __('owner/feed/posts.your_friend_on_facebook') }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item p-3" href="#">
                                            <div class="d-flex align-items-top">
                                                <i class="ri-user-unfollow-line h4"></i>
                                                <div class="data ms-2">
                                                    <h6>{{ __('owner/feed/posts.friends_except') }}</h6>
                                                    <p class="mb-0">
                                                        {{ __('owner/feed/posts.dont_show_to_some_friends') }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item p-3" href="#">
                                            <div class="d-flex align-items-top">
                                                <i class="ri-notification-line h4"></i>
                                                <div class="data ms-2">
                                                    <h6>{{ __('owner/feed/posts.only_me') }}</h6>
                                                    <p class="mb-0">{{ __('owner/feed/posts.only_me') }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn btn-primary d-block w-100 mt-3">{{ __('owner/feed/posts.post') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
