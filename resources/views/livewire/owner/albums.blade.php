<div class="card">
    <div class="card-body">
        <h2>Albumes</h2>
        <div class="row mt-2">
            <div class="col-md-3">
                <ul class="nav nav-pills list-inline p-0 m-0 flex-column">
                    @foreach ($albums as $key => $album)
                        <li>
                            <a class="nav-link d-flex justify-content-between @if ($key == 0) active @endif" data-bs-toggle="pill"
                                href="#pill-{{ $album->id }}" data-bs-target="#album_{{ $album->id }}">
                                {{ $album->name }}
                                @if ($album->accessMode !== 'free')
                                    <span class="badge bg-danger h-100"><i class="las la-hand-holding-usd"></i></span>
                                @else
                                    <span class="badge bg-success h-100"><i class="las la-hand-holding-heart"></i></span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-9 ps-4">
                <div class="tab-content">
                    @foreach ($albums as $key => $album)
                        @php
                            $album->data = json_decode($album->data, true);
                        @endphp
                        <div class="tab-pane fade @if ($key == 0) active show @endif"
                            id="album_{{ $album->id }}" role="tabpanel">
                            <div class="card-body p-0">
                                <h4 class="mb-2">{{ $album->name }}</h4>
                                <div class="row">
                                    <div class="col-3">
                                        <h6>Acceso</h6>
                                    </div>
                                    <div class="col-9">
                                        <p class="mb-0">{{ $album->data['accessMode'] }}</p>
                                    </div>
                                    <div class="col-3">
                                        <h6>Likes</h6>
                                    </div>
                                    <div class="col-9">
                                        <p class="mb-0">{{ $album->data['likes'] }}</p>
                                    </div>
                                    <div class="col-3">
                                        <h6>Creado</h6>
                                    </div>
                                    <div class="col-9">
                                        <p class="mb-0">
                                            {{ \Carbon\Carbon::parse($album->data['createdAt'])->subHours(5)->format('d M, Y - H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-grid gap-2 d-grid-template-1fr-13">
                                    @foreach ($album->photos as $photo)
                                        <div class="">
                                            <div class="user-images position-relative overflow-hidden">
                                                <a href="#">
                                                    @if (!empty($photo->urlThumb))
                                                        <img src="{{ $photo->urlThumb }}" class="img-fluid rounded"
                                                            alt="Responsive image">
                                                    @else
                                                        <img src="{{ $photo->urlThumbMicro }}"
                                                            class="img-fluid rounded w-100 blur_avatar"
                                                            alt="Responsive image">
                                                    @endif
                                                </a>
                                                {{-- <div class="image-hover-data">
                                                    <div class="product-elements-icon">
                                                        <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                            <li><a href="#" class="pe-3 text-white"> 60 <i
                                                                        class="ri-thumb-up-line"></i> </a>
                                                            </li>
                                                            <li><a href="#" class="pe-3 text-white"> 30 <i
                                                                        class="ri-chat-3-line"></i> </a>
                                                            </li>
                                                            <li><a href="#" class="pe-3 text-white"> 10 <i
                                                                        class="ri-share-forward-line"></i>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div> --}}
                                                {{-- <a href="#" class="image-edit-btn" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title=""
                                                    data-bs-original-title="Edit or Remove"><i
                                                        class="ri-edit-2-fill"></i>
                                                </a> --}}
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
