<div wire:poll.5s>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Goal</h5>
                    @if (isset($owner->data->cam->goal))
                        @php
                            $goal = $owner->data->cam->goal;
                            $current = $goal->left * 100 / $goal->goal;
                        @endphp
                        <p class="card-text">{{ $goal->description }}. <br/>Meta {{ $goal->goal }} | {{ round($current) }}% <small>({{ $goal->left }})</small></p>
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
                        <p class="card-text">Online</p>
                    @endif

                    <h5 class="card-title">King</h5>
                    @if (isset($owner->data->cam->king))
                        @php
                            $king = $owner->data->cam->king;
                        @endphp
                        <p class="card-text">{{ $king->username }} | Level {{ $king->userRanking->level }}</p>
                        @if ($king->userRanking->isEx)
                            <small>EX {{ $king->userRanking->league }}</small>
                        @endif
                    @else
                        <p class="card-text">No king set</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

