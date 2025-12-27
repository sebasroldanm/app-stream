@foreach ($posts as $pst)
    <div class="user-post">
        @if (!empty($pst->body))
            <p>{{ $pst->body }}</p>
        @endif
        <div class="row">
            @foreach ($pst->mediaPostFeeds as $media)
                @switch($pst->mediaPostFeeds->count())
                    @case(1)
                        <div class="col-lg-12 text-center">
                            <img src="{{ $media->url }}" class="img-fluid rounded fullviewer max-vh-60"
                                alt="{{ $pst->body }}">
                        </div>
                    @break

                    @case(2)
                        <div class="col-lg-6 container-overlay">
                            <img src="{{ $media->url }}" data-images-full='@json($pst->mediaPostFeeds->pluck('url'))'
                                data-images-thumb='@json($pst->mediaPostFeeds->pluck('urlThumb'))'
                                class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                alt="{{ $pst->body }}">
                        </div>
                    @break

                    @case(3)
                        <div class="col-lg-4 mb-2 container-overlay">
                            <img src="{{ $media->url }}" data-images-full='@json($pst->mediaPostFeeds->pluck('url'))'
                                data-images-thumb='@json($pst->mediaPostFeeds->pluck('urlThumb'))'
                                class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                alt="{{ $pst->body }}">
                        </div>
                    @break

                    @default
                        <div class="col-lg-4 mb-2">
                            <img src="{{ $media->url }}" class="img-fluid rounded fullviewer max-vh-60"
                                alt="{{ $pst->body }}">
                        </div>
                    @break
                @endswitch
            @endforeach
        </div>
    </div>
    @include('components.feeds.actions', ['item' => $pst])
@endforeach
