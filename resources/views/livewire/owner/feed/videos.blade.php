<div>
    @if ($videos->count() > 0)
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{ __('owner/feed/panels.videos') }} ({{ $videos->count() }})</h4>
                </div>
                <div class="card-header-toolbar d-flex align-items-center">
                    <p class="m-0"><a
                            href="{{ route('owner.videos', $owner->username) }}">{{ __('owner/feed/panels.view_videos') }}</a>
                    </p>
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
