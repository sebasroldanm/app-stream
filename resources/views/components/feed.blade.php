@if (
    $feed->type === 'offlineStatusChanged' ||
        (($feed->type !== 'offlineStatusChanged' && $feed->postFeed->count() > 0) ||
            $feed->albumFeed->count() > 0 ||
            $feed->videoFeed->count() > 0))
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="post-item">
                    <div class="user-post-data pb-3">
                        <div class="d-flex justify-content-between">
                            <div class="me-3">
                                <img class="rounded-circle avatar-60" src="{{ $feed->owner->avatar }}"
                                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $feed->owner->username }}';"
                                    alt="">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="">
                                        <h5 class="mb-0 d-inline-block"><a
                                                href="{{ route('owner', $feed->owner->username) }}"
                                                class="">{{ $feed->owner->username }}</a></h5>
                                        <p class="ms-1 mb-0 d-inline-block">
                                            @switch($feed->type)
                                                @case('postAdded')
                                                    Nueva publicación
                                                @break

                                                @case('albumUpdated')
                                                    Album actualizado
                                                @break

                                                @case('videoAdded')
                                                    Nuevo video
                                                @break

                                                @default
                                                    Nuevo estado
                                            @endswitch
                                        </p>
                                        <p class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="{{ Carbon\Carbon::parse($feed->updatedAt)->format('d M, Y - H:i:s') }}">
                                            {{ \Carbon\Carbon::parse($feed->updatedAt)->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="card-post-toolbar">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" role="button">
                                                <i class="ri-more-fill"></i>
                                            </span>
                                            <div class="dropdown-menu m-0 p-0">
                                                <a class="dropdown-item p-3"
                                                    href="{{ route('metadata', ['model' => 'feed', 'id' => $feed->id]) }}"
                                                    target="_blank">
                                                    <div class="d-flex align-items-top">
                                                        <i class="fas fa-link h4"></i>
                                                        <div class="data ms-2">
                                                            <h6>Ver Meta datos</h6>
                                                            <p class="mb-0">Ver metadatos en
                                                                formato Json.</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                {{-- <a class="dropdown-item p-3" href="#">
                                                                <div class="d-flex align-items-top">
                                                                    <i class="ri-save-line h4"></i>
                                                                    <div class="data ms-2">
                                                                        <h6>Save Post</h6>
                                                                        <p class="mb-0">Add this to your
                                                                            saved items
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a class="dropdown-item p-3" href="#">
                                                                <div class="d-flex align-items-top">
                                                                    <i class="ri-close-circle-line h4"></i>
                                                                    <div class="data ms-2">
                                                                        <h6>Hide Post</h6>
                                                                        <p class="mb-0">See fewer posts like
                                                                            this.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a class="dropdown-item p-3" href="#">
                                                                <div class="d-flex align-items-top">
                                                                    <i class="ri-user-unfollow-line h4"></i>
                                                                    <div class="data ms-2">
                                                                        <h6>Unfollow User</h6>
                                                                        <p class="mb-0">Stop seeing posts but
                                                                            stay
                                                                            friends.</p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a class="dropdown-item p-3" href="#">
                                                                <div class="d-flex align-items-top">
                                                                    <i class="ri-notification-line h4"></i>
                                                                    <div class="data ms-2">
                                                                        <h6>Notifications</h6>
                                                                        <p class="mb-0">Turn on notifications
                                                                            for
                                                                            this post</p>
                                                                    </div>
                                                                </div>
                                                            </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <code>{{ $feed->id }}</code> --}}

                    {{-- {{ dd($feed) }} --}}

                    @if ($feed->type == 'offlineStatusChanged')
                        <div class="user-post">
                            <h5 class="text-center my-5">
                                {{ json_decode($feed->data)->data->offlineStatus }}</h5>
                        </div>
                    @else
                        @foreach ($feed->postFeed as $pst)
                            <div class="user-post">
                                @if (!empty($pst->body))
                                    <p>{{ $pst->body }}</p>
                                @endif
                                <div class="row">
                                    @foreach ($pst->mediaPostFeeds as $media)
                                        @switch($pst->mediaPostFeeds->count())
                                            @case(1)
                                                <div class="col-lg-12 text-center">
                                                    <img src="{{ $media->url }}"
                                                        class="img-fluid rounded fullviewer max-vh-60"
                                                        alt="{{ $pst->body }}">
                                                </div>
                                            @break

                                            @case(2)
                                                <div class="col-lg-6 container-overlay">
                                                    <img src="{{ $media->url }}"
                                                        data-images-full='@json($pst->mediaPostFeeds->pluck('url'))'
                                                        data-images-thumb='@json($pst->mediaPostFeeds->pluck('urlThumb'))'
                                                        class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                                        alt="{{ $pst->body }}">
                                                </div>
                                            @break

                                            @case(3)
                                                <div class="col-lg-4 mb-2 container-overlay">
                                                    <img src="{{ $media->url }}"
                                                        data-images-full='@json($pst->mediaPostFeeds->pluck('url'))'
                                                        data-images-thumb='@json($pst->mediaPostFeeds->pluck('urlThumb'))'
                                                        class="img-fluid rounded fullviewer max-vh-60 _overlay pics_feed"
                                                        alt="{{ $pst->body }}">
                                                </div>
                                            @break

                                            @default
                                                <div class="col-lg-4 mb-2">
                                                    <img src="{{ $media->url }}"
                                                        class="img-fluid rounded fullviewer max-vh-60"
                                                        alt="{{ $pst->body }}">
                                                </div>
                                            @break
                                        @endswitch
                                    @endforeach
                                </div>
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
                                                </div>
                                            </div>
                                            <div class="total-like-block ms-2 me-3">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false" role="button">
                                                        {{ $pst->likes }} Likes
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($feed->albumFeed as $album)
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
                                                        <img src="{{ $photo->urlPreview }}"
                                                            class="img-fluid rounded fullviewer max-vh-60"
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
                                                    <img src="{{ $photo->url }}"
                                                        class="img-fluid rounded fullviewer max-vh-60"
                                                        alt="{{ $album->body }}">
                                                </div>
                                            @else
                                                <div class="col-2 my-2 container-overlay rounded">
                                                    <img src="{{ $photo->urlThumbMicro }}"
                                                        class="img-fluid w-100 _overlay filter_blur_10"
                                                        alt="{{ $album->body }}">
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="comment-area mt-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="like-block position-relative d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="like-data">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false" role="button">
                                                        <img src="{{ asset('/images/icon/01.png') }}"
                                                            class="img-fluid" alt="">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="total-like-block ms-2 me-3">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false" role="button">
                                                        {{ $album->likes }} Likes
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- {{dd($feed)}} --}}
                        @foreach ($feed->videoFeed as $video)
                            <div class="user-post">
                                @if (!empty($video->title))
                                    <p>{{ $video->title }}</p>
                                @endif
                                <div class="row">

                                    <div class="col-lg-12">
                                        <video class="video_feed" data-poster="{{ $video->coverUrl }}"
                                            @if ($video->videoUrl) data-video="{{ $video->videoUrl }}"
                                                    data-format="{{ $video->format_video }}"
                                                @else
                                                    data-video="{{ $video->trailerUrl }}"
                                                    data-format="{{ $video->format_trailer }}" @endif>
                                        </video>
                                    </div>

                                </div>
                            </div>
                            <div class="comment-area mt-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="like-block position-relative d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="like-data">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false" role="button">
                                                        <img src="{{ asset('/images/icon/01.png') }}"
                                                            class="img-fluid" alt="">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="total-like-block ms-2 me-3">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false" role="button">
                                                        {{ $video->likes }} Likes
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
