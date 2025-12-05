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
                                        <img src="{{ URL::to('/') . auth()->guard('customer')->user()->avatar }}"
                                            alt="userimg" class="avatar-60 rounded-circle">
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
                                                    <img src="{{ URL::to('/') . auth()->guard('customer')->user()->avatar }}"
                                                        alt="userimg" class="avatar-60 rounded-circle img-fluid">
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
                                                            <img src="{{ URL::to('/') . auth()->guard('customer')->user()->avatar }}"
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
                        @include('components.feed', ['feed' => $feed])
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
                                            <h5><a
                                                    href="{{ route('owner', $own_fav->username) }}">{{ $own_fav->username }}</a>
                                            </h5>
                                            <p class="mb-0">
                                                {{ \Carbon\Carbon::parse($own_fav->statusChangedAt)->diffForHumans() }}
                                            </p>
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
                                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $ownr_b->username }}';"
                                            class="rounded-circle img-fluid">
                                        <div class="stories-data ms-3">
                                            <h5>
                                                <a href="{{ route('owner', $ownr_b->username) }}">{{ $ownr_b->username }}</a>
                                            </h5>

                                            @php
                                                $birth = \Carbon\Carbon::parse($ownr_b->birthDate);
                                                $today = \Carbon\Carbon::today();

                                                // Próximo cumpleaños
                                                $nextBirthday = $birth->copy()->year($today->year);

                                                // Manejo de 29/02 en años no bisiestos
                                                if ($birth->format('m-d') === '02-29' && !$nextBirthday->isLeapYear()) {
                                                    $nextBirthday->day(28);
                                                }

                                                // Si ya pasó este año, usamos el próximo año
                                                if ($nextBirthday->lt($today)) {
                                                    $nextBirthday->addYear();
                                                    if (
                                                        $birth->format('m-d') === '02-29' &&
                                                        !$nextBirthday->isLeapYear()
                                                    ) {
                                                        $nextBirthday->day(28);
                                                    }
                                                }

                                                // Días que faltan (entero)
                                                $days = $today->diffInDays($nextBirthday, false);

                                                // Edad que va a cumplir
                                                $age = $nextBirthday->year - $birth->year;

                                                // Mensaje final
                                                if ($days == 0) {
                                                    $message = "Hoy cumple {$age} años";
                                                } elseif ($days == 1) {
                                                    $message = "Mañana cumple {$age} años";
                                                } else {
                                                    $message =
                                                        "Faltan {$days} días para su cumpleaños ({$age} años) " .
                                                        $ownr_b->birthDate;
                                                }
                                            @endphp

                                            <p class="mb-0">{{ $message }}</p>

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
