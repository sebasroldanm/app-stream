@foreach ($videos as $video)
    <div class="user-post">
        @if (!empty($video->title))
            <p>{{ $video->title }}</p>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <video class="video_feed" data-poster="{{ $video->coverUrl }}"
                    @if ($video->videoUrl) data-video="{{ $video->videoUrl }}"
                            data-format="{{ $this->returnFormatByUrl($video->videoUrl) }}"
                        @else
                            data-video="{{ $video->trailerUrl }}"
                            data-format="{{ $this->returnFormatByUrl($video->trailerUrl) }}" @endif>
                </video>
            </div>
        </div>
    </div>
    @include('components.feeds.actions', ['item' => $video])
@endforeach
