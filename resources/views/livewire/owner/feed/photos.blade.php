<div>
    @if ($photos->count() > 0)
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{ __('owner/feed/panels.photos') }} ({{ $photos->count() }})</h4>
                </div>
                <div class="card-header-toolbar d-flex align-items-center">
                    <p class="m-0"><a
                            href="{{ route('owner.albums', $owner->username) }}">{{ __('owner/feed/panels.view_albums') }}</a>
                    </p>
                </div>
            </div>
            <div class="card-body">
                <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                    @foreach ($photos as $photo)
                        <li class="feed-bg-lists container-overlay">
                            <img src="{{ $photo->urlThumb }}" data-image_vh="{{ $photo->url }}" alt="gallary-image"
                                class="img-fluid _overlay fullviewer" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
