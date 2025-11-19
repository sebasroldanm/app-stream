{{-- <div class="right-sidebar-mini right-sidebar" wire:init="loadData">
    <div class="right-sidebar-panel p-0">
        <div class="card shadow-none">
            <div class="card-body p-0">
                <div class="media-height p-3" data-scrollbar="init">
                    <div wire:loading>
                        @for ($i = 0; $i < $limit; $i++)
                            <div class="d-flex align-items-center mb-4" wire:loading>
                                <div class="iq-profile-avatar">
                                    <div class="avatar-skeleton"></div>
                                </div>
                                <div class="ms-3">
                                    <div class="skeleton-loader"></div>
                                    <div class="skeleton-loader"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    @if (count($owners) > 0)
                        @foreach ($owners as $owner)
                            <div class="d-flex align-items-center mb-4">
                                <div
                                    class="iq-profile-avatar @if ($owner->isLive) status-live @else @if ($owner->isOnline) status-online @endif @endif">
                                    <a href="{{ route('owner.feed', $owner->username) }}">
                                        <img class="rounded-circle avatar-50" src="{{ $owner->avatar }}" alt="">
                                    </a>
                                </div>
                                <div class="ms-3">
                                    <a href="{{ route('owner.feed', $owner->username) }}">
                                        <h6 class="mb-0">{{ $owner->username }}</h6>
                                    </a>
                                    <p class="mb-0">
                                        @if ($owner->isLive)
                                            En Vivo
                                        @else
                                            {{ \Carbon\Carbon::parse($owner->statusChangedAt)->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No Disponile
                    @endif
                </div>
                <div class="right-sidebar-toggle bg-primary text-white mt-3">
                    <i class="ri-arrow-left-line side-left-icon"></i>
                    <i class="ri-arrow-right-line side-right-icon"><span class="ms-3 d-inline-block">Close
                            Menu</span></i>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="right-sidebar-mini right-sidebar">
    <div class="right-sidebar-panel p-0">
        <div class="card shadow-none">
            <div class="card-body p-0">
                <div class="media-height p-3" data-scrollbar="init">
                    @foreach ($owners as $owner)
                        <div class="d-flex align-items-center mb-4">
                            <div
                                class="iq-profile-avatar @if ($owner->isLive) status-live @else @if ($owner->isOnline) status-online @endif @endif">
                                <a href="{{ route('owner.feed', $owner->username) }}">
                                    <img class="rounded-circle avatar-50" src="{{ $owner->avatar }}" 
                                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $owner->username }}';"
                                    alt="">
                                </a>
                            </div>
                            <div class="ms-3">
                                <a href="{{ route('owner.feed', $owner->username) }}">
                                    <h6 class="mb-0">{{ $owner->username }}</h6>
                                </a>
                                <p class="mb-0">
                                    @if ($owner->isLive)
                                        En Vivo
                                    @else
                                        {{ \Carbon\Carbon::parse($owner->statusChangedAt)->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="right-sidebar-toggle bg-primary text-white mt-3">
                    <i class="ri-arrow-left-line side-left-icon"></i>
                    <i class="ri-arrow-right-line side-right-icon"><span class="ms-3 d-inline-block">Close
                            Menu</span></i>
                </div>
            </div>
        </div>
    </div>
</div>
