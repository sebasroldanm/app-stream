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
                    {{-- Main Video --}}
                    @if ($video->videoUrl)
                        <div class="col-lg-12">
                            <video class="video_feed" data-poster="{{ $video->coverUrl }}"
                                data-video="{{ $video->videoUrl }}"
                                data-format="{{ $this->returnFormatByUrl($video->videoUrl) }}">
                            </video>
                        </div>
                    {{-- Trailer --}}
                    @else ($video->trailerUrl)
                        <div class="col-lg-12">
                            <video class="video_feed" data-poster="{{ $video->coverUrl }}"
                                data-video="{{ $video->trailerUrl }}"
                                data-format="{{ $this->returnFormatByUrl($video->trailerUrl) }}">
                            </video>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
