<div class="card-body p-0">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ __('owner/feed/panels.title') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="event-post position-relative">
                                <div class="card-body">
                                    @if (isset($owner->data))

                                        @if ($description !== false)
                                            <p>{{ $description }}</p>
                                            <hr>
                                        @endif
                                        @if ($country !== false)
                                            <p><i class="las la-home"></i> {{ __('owner/feed/panels.country') }} {!! $country !!}
                                            </p>
                                        @endif
                                        @if ($languages !== false)
                                            <p><i class="las la-globe"></i> {{ __('owner/feed/panels.languages') }} {!! $languages !!}</p>
                                        @endif
                                        @if ($gender !== false)
                                            <p><i class="las la-users"></i> {{ __('owner/feed/panels.gender') }} {!! $gender !!}</p>
                                        @endif
                                        @if ($age !== false)
                                            <p><i class="las la-gifts"></i> {{ __('owner/feed/panels.age', ['age' => $age]) }}</p>
                                        @endif
                                    @else
                                        <h5 class="text-center">{{ __('owner/feed/panels.no_results') }}</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($photos->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ __('owner/feed/panels.photos') }} @if ($owner->data)
                                    ({{ $owner->data->user->photosCount }})
                                @endif
                            </h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p class="m-0"><a href="{{ route('owner.albums', $owner->username) }}">{{ __('owner/feed/panels.view_albums') }}</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                            @foreach ($photos as $photo)
                                <li class="feed-bg-lists container-overlay">
                                    <img src="{{ $photo->urlThumb }}" data-image_vh="{{ $photo->url }}"
                                        alt="gallary-image" class="img-fluid _overlay fullviewer" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if ($videos->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ __('owner/feed/panels.videos') }} @if ($owner->data)
                                    ({{ $owner->data->user->videosCount }})
                                @endif
                            </h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <p class="m-0"><a href="{{ route('owner.videos', $owner->username) }}">{{ __('owner/feed/panels.view_videos') }}</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                            @foreach ($videos as $video)
                                <li class="feed-bg-lists container-overlay">
                                    <img src="{{ $video->coverUrl }}" alt="gallary-image" class="img-fluid _overlay"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="{{ $video->title }}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        @livewire('owner.feed.posts', ['owner' => $owner])
    </div>
</div>
