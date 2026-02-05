<div wire:poll.5s>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Goal</h5>
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

                        <p class="card-text">Meta {{ $goal->spent }} / {{ $goal->goal }}</p>
                    @else
                        <p class="card-text">No goal set</p>
                    @endif
                    @if (isset($owner->data->cam->topic))
                        <h5>Topic:</h5>
                        <p class="card-text">{{ $owner->data->cam->topic }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5>Estado</h5>
                    @if (isset($owner->data->cam->show))
                        <p class="card-text">{{ $owner->data->cam->show->mode }}</p>
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
                        $views_count = $viewers->guests + $viewers->spies + $viewers->invisibles + $viewers->greens + $viewers->golds + $viewers->regulars;
                    @endphp
                    <h5 class="card-title">Viewers: <span>{{ $views_count }}</span></h5>

                    <h5 class="card-title">King</h5>
                    @if (isset($owner->data->cam->king))
                        @php
                            $king = $owner->data->cam->king;
                            $isEx = $king->userRanking->isEx;
                            $league = $king->userRanking->league;
                        @endphp
                        @if ($isEx)
                            <p class="card-text">{{ $king->username }} <sup class="text-{{ $league }}">EX</sup> |
                                Level {{ $king->userRanking->level }}</p>
                        @else
                            <p class="card-text text-{{ $league }}">{{ $king->username }} | Level
                                {{ $king->userRanking->level }}</p>
                        @endif
                    @else
                        <p class="card-text">No king set</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Viendo ahora</h5>
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
                                            class="fw-bold text-{{ $league }}">EX</sup> | Level {{ $level }}</p>
                                @else
                                    <p class="fw-bold card-text text-{{ $league }}">{{ $user->username }} | Level
                                        {{ $level }}</p>
                                @endif
                            @endforeach
                        @endif
                        @if ($viewers->guests > 0)
                            <p class="card-text">Visitantes: {{ $viewers->guests }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <style>
        .progress-container {
            width: 100%;
            max-width: 420px;
            height: 30px;
            background-color: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar {
            position: relative;
            height: 100%;
            width: 0%;
            background-color: #86efac;
            /* verde claro */
            transition: width 0.6s ease;
            overflow: hidden;
        }

        /* Brillo suave interno */
        .progress-shimmer {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.35) 50%,
                    rgba(255, 255, 255, 0) 100%);
            background-size: 200% 100%;
            animation: shimmerMove 1.6s ease-in-out infinite;
            z-index: 1;
        }

        .progress-bar.complete .progress-shimmer {
            animation: none;
            background: none;
        }

        .progress-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: #064e3b;
            /* verde oscuro */
            z-index: 2;
            pointer-events: none;
        }

        @keyframes shimmerMove {
            from {
                background-position: 200% 0;
            }

            to {
                background-position: -200% 0;
            }
        }

        /* Demo buttons */
        .controls {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        button {
            padding: 8px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            background: #064e3b;
            color: #fff;
            font-weight: 500;
        }

        button:hover {
            opacity: 0.9;
        }
    </style> --}}
</div>
