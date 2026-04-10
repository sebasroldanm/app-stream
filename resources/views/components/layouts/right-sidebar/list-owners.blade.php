<div class="media-height p-3" data-scrollbar="init">
    @foreach ($owners as $owner)
        <div class="d-flex align-items-center mb-4">
            <div
                class="iq-profile-avatar @if ($owner->isLive) status-live @else @if ($owner->isOnline) status-online @endif @endif">
                <a href="{{ route('owner.feed', $owner->username) }}">
                    <img class="rounded-circle avatar-50" src="{{ $owner->pic_profile }}"
                        alt="Pic Profile {{ $owner->username }}">
                </a>
            </div>
            <div class="ms-3">
                <a href="{{ route('owner.feed', $owner->username) }}">
                    <h6 class="mb-0" title="{{ $owner->username }}">{{ str($owner->username)->limit(14) }}</h6>
                </a>
                <p class="mb-0">
                    @if ($owner->isLive)
                        {{ __('sidebar.live') }}
                    @else
                        {{ \Carbon\Carbon::parse($owner->statusChangedAt)->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>
    @endforeach
</div>
