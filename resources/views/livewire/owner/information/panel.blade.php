<div class="row">
    <div class="col-sm-12">
        <h4 class="mb-3">Pannels</h4>
        <div class="row masonry">
            @foreach ($panels as $panel)
                <div class="col-sm-6 col-lg-6 masonry-item">
                    <div class="card mb-3" style="break-inside: avoid;">
                        @if ($panel->imageUrl !== '')
                            <img src="{{ $panel->imageUrl }}" class="rounded fullviewer" alt="Panel owner image">
                        @endif
                        @if ($panel->body !== '' || $panel->title !== '')
                            <div class="card-body">
                                @if ($panel->title !== '')
                                    <h5 class="card-title">{{ $panel->title }}</h5>
                                @endif
                                @if ($panel->body !== '')
                                    <p class="card-text">{{ $panel->body }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            @if (count($panels) == 0)
                <h5 class="text-center">Sin perfil :(</h5>
            @endif
        </div>
    </div>
</div>
