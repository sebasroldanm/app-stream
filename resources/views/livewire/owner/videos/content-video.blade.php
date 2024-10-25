<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ $video->coverUrl }}" class="card-img" alt="..." />
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        <p class="card-text">{{ $video->description }}</p>
                        <div class="row">
                            <div class="col-3">
                                <h6>Acceso</h6>
                            </div>
                            <div class="col-9">
                                {{ $video->accessMode }}
                            </div>
                            <div class="col-3">
                                <h6>Duración</h6>
                            </div>
                            <div class="col-9">
                                {{ $duration }}
                            </div>
                        </div>
                        {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                    </div>
                </div>
                <div class="col-md-12 mt-2 px-5">
                    <img src="{{ $video->coverUrl }}" alt="post-image" class="img-fluid card" />
                    {{-- <video id="my_video_1"
                        class="video-js vjs-default-skin"
                        width="740px" height="420px"
                        controls preload="none"
                        data-setup='{}'>
                    </video> --}}
                    {{-- <video id="my_video_1"
                    poster="{{ $video->coverUrl }}"
                    src="{{ $video->url ? $video->url : $video->trailerUrl }}"
                    width="100%"></video> --}}

                    <a class="video-play-button" wire:click="playTrailer({{ $video }})">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 104 104"
                            enable-background="new 0 0 104 104" xml:space="preserve">
                            <path fill="none" stroke="#50b5ff" stroke-width="4" stroke-miterlimit="10"
                                d="M26,35h52L52,81L26,35z" />
                            <circle class="video-play-circle" fill="none" stroke="#50b5ff" stroke-width="4"
                                stroke-miterlimit="10" cx="52" cy="52" r="50" />
                        </svg>
                        <span class="video-play-outline"></span>
                    </a>
                </div>
                {{-- {{ dd($video) }} --}}
                <button id="event_trailer" class="d-none" data-bs-toggle="modal"
                    data-bs-target=".modal-video-owner"></button>
                <div class="row my-4 d-flex justify-content-center">
                    <div class="col-md-4">
                        @if ($video->videoUrl)
                            <button wire:click="playVideo({{ $video }})" type="submit"
                                class="btn btn-primary d-block w-100 mt-3">Ver Contenido</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
