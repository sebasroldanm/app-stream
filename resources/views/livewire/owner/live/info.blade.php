<div class="row" wire:poll.10s.visible>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('owner/live/info.goal') }}</h5>
                @if (isset($owner->data->cam->goal))
                    @php
                        $goal = $owner->data->cam->goal;
                    @endphp
                    <h5>{{ $goal->description }}</h5>

                    <div class="progress" style="height: 20px;" wire:ignore>
                        <div id="progressBar"
                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                            role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                            aria-valuemax="100">
                            <span id="progressText"></span>
                        </div>
                    </div>

                    <p class="card-text">{{ __('owner/live/info.goal') }} {{ $goal->spent }} / {{ $goal->goal }}
                    </p>
                @else
                    <p class="card-text">{{ __('owner/live/info.no_goal') }}</p>
                @endif
                @if (isset($owner->data->cam->topic))
                    <h5>{{ __('owner/live/info.topic') }}:</h5>
                    <p class="card-text">{{ $owner->data->cam->topic }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5>{{ __('owner/live/info.status') }}</h5>
                @if ($owner->show_model)
                    <p class="card-text">{{ $owner->show_model }}</p>
                @else
                    @php
                        if ($owner->data->user->user->isLive) {
                            $state = 'Live';
                            $type = 'badge border border-red text-red text-bold';
                        } elseif ($owner->data->user->user->isOnline) {
                            $state = 'Online';
                            $type = 'badge border border-success text-success text-bold';
                        } else {
                            $state = 'Offline';
                            $type = 'badge border border-secondary text-secondary text-bold';
                        }
                    @endphp
                    <span class="badge {{ $type }}">{{ $state }}</span>
                @endif

                @php
                    $views_count =
                        $viewers->guests +
                        $viewers->spies +
                        $viewers->invisibles +
                        $viewers->greens +
                        $viewers->golds +
                        $viewers->regulars;
                @endphp
                <h5 class="card-title">{{ __('owner/live/info.viewers') }}: <span>{{ $views_count }}</span></h5>

                <h5 class="card-title">{{ __('owner/live/info.king') }}</h5>
                @if (isset($owner->data->cam->king))
                    @php
                        $king = $owner->data->cam->king;
                        $isEx = $king->userRanking->isEx;
                        $league = $king->userRanking->league;
                    @endphp
                    @if ($isEx)
                        <p class="card-text">{{ $king->username }} <sup class="text-{{ $league }}">EX</sup>
                            |
                            Level {{ $king->userRanking->level }}</p>
                    @else
                        <p class="card-text text-{{ $league }}">{{ $king->username }} | Level
                            {{ $king->userRanking->level }}</p>
                    @endif
                @else
                    <p class="card-text">{{ __('owner/live/info.no_king') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('owner/live/info.viewing_now') }}</h5>
                <div class="viewers-list">

                    @if (isset($viewers->members))
                        @foreach ($viewers->members as $member)
                            @php
                                $user = $member->user;
                                $isEx = $user->userRanking->isEx;
                                $level = $user->userRanking->level;
                                $league = $user->userRanking->league;
                            @endphp
                            @if ($isEx)
                                <p class="fw-bold card-text">{{ $user->username }} <sup
                                        class="fw-bold text-{{ $league }}">EX</sup> | Level
                                    {{ $level }}</p>
                            @else
                                <p class="fw-bold card-text text-{{ $league }}">{{ $user->username }} |
                                    Level
                                    {{ $level }}</p>
                            @endif
                        @endforeach
                    @endif
                    @if ($viewers->guests > 0)
                        <p class="card-text">{{ __('owner/live/info.visitors') }}: {{ $viewers->guests }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
