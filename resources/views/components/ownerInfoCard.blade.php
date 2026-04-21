<div class="user-post-data position-relative">
    <a href="{{ route('owner', $owner->username) }}" class="d-block">
        <div class="image-container overflow-hidden rounded shadow-sm position-relative">

            <!-- Primary image -->
            @if (isset($owner->pic_profile))
                <!-- Pensado para Owner -->
                <img src="{{ $owner->pic_profile }}" class="card-img-top _overlay" alt="#">
            @else
                <img src="{{ $owner->previewUrlThumbSmall }}" class="card-img-top _overlay" alt="#">
            @endif

            {{-- <!-- Secondary image -->
            @if (isset($owner->popularSnapshotTimestamp))
                <img src="https://img.doppiocdn.net/thumbs/{{ $owner->popularSnapshotTimestamp }}/{{ $owner->id }}"
                    class="card-img-top _overlay" alt="#">
            @endif

            <!-- Tertiary image -->
            @if (isset($owner->verifiedSnapshotTimestamp))
                <img src="https://img.doppiocdn.net/thumbs/{{ $owner->verifiedSnapshotTimestamp }}/{{ $owner->id }}"
                    class="card-img-top _overlay" alt="#">
            @endif --}}

            <div class="position-absolute top-0 start-0 m-1">
                <span class="badge bg-dark-50 text-white shadow-sm">
                    <i class="las {{ $owner->isMobile ? 'la-mobile-alt' : 'la-laptop' }}"></i>
                </span>
            </div>

            @if ($owner->isNew)
                <div class="position-absolute top-0 end-0 m-1">
                    <span class="badge bg-warning text-dark fw-bold">{{ __('owner/related.new') }}</span>
                </div>
            @endif

            <div class="position-absolute bottom-0 end-0 m-2">
                <span class="badge bg-dark text-white opacity-75">
                    {{ $owner->viewersCount }} <i class="las la-eye"></i>
                </span>
            </div>
        </div>
        <div class="mt-2 text-center">
            <h6 class="mb-0 text-truncate">{{ $owner->username }}</h6>
            @if (isset($favs) && in_array($owner->id, $favs))
                <i class="las la-heart text-danger"></i>
            @endif
        </div>
    </a>
</div>
