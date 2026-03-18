<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3 d-flex justify-content-between">
            {{ __('owner/ia/results.title') }}
            @if ($similarity !== false)
                <a href="{{ route('metadata', ['model' => 'similarity', 'id' => $owner->id]) }}" target="_blank">
                    <i class="fas fa-link"></i>
                </a>
            @endif
        </h4>
    </div>
    <div class="row">
        @if ($similarity === false)
            <div class="col-md-12">
                <h5 class="mb-3 text-center">{{ __('owner/ia/results.no_results') }}</h5>
            </div>
        @else
            <button type="button" wire:click="seeFull" class="btn btn-soft-primary mb-1">
                @if (!$see_full)
                    {{ __('owner/ia/results.see_full') }}
                @else
                    {{ __('owner/ia/results.hide_full') }}
                @endif
            </button>
            @foreach ($similarity as $result)
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="ia_similarity">
                        <div class="row card">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5 p-0">
                                        <img src="{{ $result->urls->faceImage }}" alt="profile-img"
                                            class="img-fluid rounded">
                                    </div>
                                    <div class="col-7">
                                        <div class="info">
                                            <h5>{{ $result->model }}</h5>
                                            @php
                                                switch ($result->probability) {
                                                    case 'high':
                                                        $class = 'success';
                                                        break;
                                                    case 'medium':
                                                        $class = 'warning';
                                                        break;
                                                    case 'low':
                                                        $class = 'danger';
                                                        break;
                                                    default:
                                                        $class = 'secondary';
                                                        break;
                                                }
                                                $similarity = (1 - floatval($result->distance)) * 100;
                                            @endphp
                                            <p class="mb-0">{{ __('owner/ia/results.probability') }}: <span class="badge bg-{{ $class }}"> {{ __('owner/ia/results.similarity_'.$result->probability) }}</span></p>
                                            <p class="mb-0">{{ __('owner/ia/results.similarity') }}: {{ round($similarity, 2) }}%</p>
                                            <p class="mb-0">{{ __('owner/ia/results.platform') }}: {{ $result->platform }}</p>
                                            <p class="mb-0">{{ __('owner/ia/results.conexion') }}:
                                                {{ \Carbon\Carbon::parse($result->seen)->diffForHumans() }}
                                            </p>
                                            <p class="mb-0">{{ __('owner/ia/results.profile') }}:
                                                {{ \Carbon\Carbon::parse($result->accountSeen)->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 py-2 text-center">
                                @if ($result->platform == 'sc')
                                    <a href="{{ route('owner.feed', $result->model) }}" class="btn btn-success" target="_blank">{{ __('owner/ia/results.see_here') }}</a>
                                @else
                                    <a href="{{ $result->urls->externalProfile }}" target="_blank"
                                        class="btn btn-danger">{{ __('owner/ia/results.visit_external_site') }}</a>
                                @endif
                            </div>
                            @if ($see_full)
                                <div class="col-12">
                                    <img src="{{ $result->urls->fullImage }}" alt="profile-img"
                                        class="img-fluid rounded">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
