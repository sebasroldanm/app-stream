@foreach ($videos as $video)
    <div class="user-post">
        @if (!empty($video->title))
            <p>{{ $video->title }}</p>
        @endif
        <div class="row">
            <div class="col-lg-12">
                @if ($video->videoUrl)
                    <x-video-component 
                        :poster="$video->coverUrl" 
                        :video="$video->videoUrl"
                    />
                @else
                    <x-video-component 
                        :poster="$video->coverUrl" 
                        :video="$video->trailerUrl"
                    />
                @endif
            </div>
        </div>
    </div>
    @include('components.feeds.actions', ['item' => $video])
@endforeach
