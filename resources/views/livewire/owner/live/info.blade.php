<div class="row" wire:poll.10s.visible>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center">
                    {{ __('owner/live/info.goal') }}
                    <i tabindex="0" class="las la-info-circle ms-2 text-primary" style="cursor: pointer; outline: none;"
                        x-data="{ popover: null }" x-init="popover = new bootstrap.Popover($el, {
                            html: true,
                            trigger: 'hover',
                            title: '{{ __('owner/live/info.history_goals') }}',
                            content: function() { return document.getElementById('history-goals-content-{{ $owner->id }}').innerHTML; }
                        })" @remove.window="if(popover) popover.dispose()">
                    </i>
                </h5>

                <div id="history-goals-content-{{ $owner->id }}" class="d-none">
                    @if (isset($historyGoals) && $historyGoals->count() > 0)
                        @foreach ($historyGoals as $hgoal)
                            @switch($hgoal->event)
                                @case('created')
                                    <span
                                        class="text-white">{{ __('owner/live/info.goals.created', ['time' => $hgoal->created_at->diffForHumans()]) }}</span>
                                @break

                                @case('updated')
                                    @foreach ($hgoal->new_data as $field => $newValue)
                                        @if ($field == 'goal')
                                            <p class="text-white">
                                                {{ __('owner/live/info.goals.updated.goal', ['old' => number_format($hgoal->old_data['goal'], 0, ',', '.'), 'new' => number_format($newValue, 0, ',', '.'), 'time' => $hgoal->created_at->diffForHumans()]) }}
                                            </p>
                                        @endif
                                    @endforeach
                                @break

                                @default
                            @endswitch
                        @endforeach
                    @else
                        <p class="mb-0 text-muted">{{ __('owner/live/info.no_history_goals') }}</p>
                    @endif
                </div>
                @if ($owner->goal_description)
                    <h6>{{ $owner->goal_description }}</h6>

                    <div class="progress" style="height: 20px;" wire:ignore>
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                            role="progressbar" style="width: {{$percent}}%;" aria-valuenow="0" aria-valuemin="0"
                            aria-valuemax="100">
                            <span id="progressText">{{$percent}} %</span>
                        </div>
                    </div>

                    <p class="card-text">{{ __('owner/live/info.goal') }} {{ $owner->goal_current }} /
                        {{ $owner->goal_target }}
                    </p>
                @else
                    <p class="card-text">{{ __('owner/live/info.no_goal') }}</p>
                @endif
                @if ($owner->cam_topic)
                    <h5>{{ __('owner/live/info.topic') }}:</h5>
                    <p class="card-text">{{ $owner->cam_topic }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5>{{ __('owner/live/info.status') }}</h5>
                <span class="badge {{ $type }}">{{ __('common.show_mode.' . $state) }}</span>

                @if($stats)
                    <h5 class="card-title">{{ __('owner/live/info.viewers') }}: <span>{{ number_format($stats->viewers, 0, ',', '.') }}</span></h5>
                @endif

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
    @if ($stats && count($stats->members) > 0)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('owner/live/info.viewing_now') }}</h5>
                    <div class="viewers-list">
                        @foreach ($stats->members as $member)
                            @if ($member->ranking_isEx)
                                <p class="fw-bold card-text">{{ $member->username }} <sup
                                        class="fw-bold text-{{ $member->ranking_league }}">EX</sup> | Level
                                    {{ $member->ranking_level }}</p>
                            @else
                                <p class="fw-bold card-text text-{{ $member->ranking_league }}">{{ $member->username }} |
                                    Level
                                    {{ $member->ranking_level }}</p>
                            @endif
                        @endforeach
                        @if ($stats->guests > 0)
                            <p class="card-text">{{ __('owner/live/info.visitors') }}: {{ $stats->guests }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
