<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3 d-flex justify-content-between">
            Similitudes con IA
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
                <h5 class="mb-3 text-center">No hay similitudes aún :(</h5>
            </div>
        @else
            <button type="button" wire:click="seeFull" class="btn btn-soft-primary mb-1">
                @if (!$see_full)
                    Ver imagen completa
                @else
                    Ocultar imagen completa
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
                                                        $text = 'Alta';
                                                        break;
                                                    case 'medium':
                                                        $class = 'warning';
                                                        $text = 'Media';
                                                        break;
                                                    case 'low':
                                                        $class = 'danger';
                                                        $text = 'Baja';
                                                        break;
                                                    default:
                                                        $class = 'secondary';
                                                        $text = 'Desconocida';
                                                        break;
                                                }
                                                $similarity = (1 - floatval($result->distance)) * 100;
                                            @endphp
                                            <p class="mb-0">Probabilidad: <span class="badge bg-{{ $class }}"> {{ $text }}</span></p>
                                            <p class="mb-0">Similitud: {{ round($similarity, 2) }}%</p>
                                            <p class="mb-0">Plataforma: {{ $result->platform }}</p>
                                            <p class="mb-0">Conexión:
                                                {{ \Carbon\Carbon::parse($result->seen)->diffForHumans() }}
                                            </p>
                                            <p class="mb-0">Perfil:
                                                {{ \Carbon\Carbon::parse($result->accountSeen)->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 py-2 text-center">
                                @if ($result->platform == 'sc')
                                    <a href="{{ route('owner.feed', $result->model) }}" class="btn btn-success">Ver
                                        aquí</a>
                                @else
                                    <a href="{{ $result->urls->externalProfile }}" target="_blank"
                                        class="btn btn-danger">Visitar sitio externo</a>
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
