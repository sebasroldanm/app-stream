@foreach ($albums as $album)
    <div class="user-post">
        @if (!empty($album->name))
            <p>{{ $album->name }}</p>
        @endif
        <div class="row @if ($feed->accessMode !== 'free') justify-content-center @endif">
            @foreach ($album->photos as $photo)
                @if ($feed->accessMode == 'free')
                    @switch($album->photos->count())
                        @case(1)
                            <div class="col-lg-12 text-center">
                                <img src="{{ $photo->urlPreview }}" class="img-fluid rounded fullviewer max-vh-60"
                                    alt="{{ $album->body }}">
                            </div>
                        @break

                        @case(2)
                            <div class="col-lg-6 container-overlay">
                                <img src="{{ $photo->urlPreview }}"
                                    data-images-full='@json($album->photos->pluck('urlPreview'))'
                                    data-images-thumb='@json($album->photos->pluck('urlThumb'))'
                                    class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                    alt="{{ $album->body }}">
                            </div>
                        @break

                        @default
                            <div class="col-lg-4 mb-2 container-overlay">
                                <img src="{{ $photo->urlThumb }}"
                                    data-images-full='@json($album->photos->pluck('urlPreview'))'
                                    data-images-thumb='@json($album->photos->pluck('urlThumb'))'
                                    data-image_vh="{{ $photo->urlPreview ? $photo->urlPreview : $photo->urlPreview }}"
                                    class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                    alt="{{ $album->body }}">
                            </div>
                        @break
                    @endswitch
                @else
                    @if ($photo->url)
                        <div class="col-lg-12 text-center">
                            <img src="{{ $photo->url }}" class="img-fluid rounded fullviewer max-vh-60"
                                alt="{{ $album->body }}">
                        </div>
                    @else
                        <div class="col-2 my-2 container-overlay rounded">
                            <img src="{{ $photo->urlThumbMicro }}" class="img-fluid w-100 _overlay filter_blur_10"
                                alt="{{ $album->body }}">
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
    @include('components.feeds.actions', ['item' => $album])
@endforeach
