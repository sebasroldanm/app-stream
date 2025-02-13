<div>
    @if (isset($owner->data))
        <h4>
            Personal
        </h4>
        <hr>
        <div class="row">
            <div class="col-3">
                <h6>ID</h6>
            </div>
            <div class="col-9"><code>{{ $owner->id }}</code></div>

            <div class="col-3">
                <h6>Nombre</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->name }}</div>

            <div class="col-3">
                <h6>Género</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->gender }}</div>

            <div class="col-3">
                <h6>País</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->country }}</div>

            <div class="col-3">
                <h6>Fecha de nacimiento</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->birthDate }}</div>

            <div class="col-3">
                <h6>Edad</h6>
            </div>
            <div class="col-9">{{ $age }}</div>

            <div class="col-3">
                <h6>Conplexión</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->bodyType }}</div>

            <div class="col-3">
                <h6>Color de ojos</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->eyeColor }}</div>

            <div class="col-3">
                <h6>Color de cabello</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->hairColor }}</div>

            <div class="col-3">
                <h6>Etnia</h6>
            </div>
            <div class="col-9">{{ $owner->data->user->user->ethnicity }}</div>
        </div>
        <h4 class="mt-4">
            Intereses
        </h4>
        <hr>
        <div class="row">
            <div class="col-12">
                @foreach ($owner->data->user->user->interests as $interest)
                    <span
                        class="badge badge-pill border border-secondary text-secondary mt-2">{{ $interest }}</span>
                @endforeach
            </div>
        </div>
        <h4 class="mt-4">
            Actividades
        </h4>
        <hr>
        <div class="row">
            <div class="col-3">
                <h6>Público</h6>
            </div>
            <div class="col-9">
                @foreach ($owner->data->user->user->publicActivities as $activity)
                    <span class="badge badge-pill border border-success text-success mt-2">{{ $activity }}</span>
                @endforeach
            </div>
            <div class="col-3">
                <h6>Privado</h6>
            </div>
            <div class="col-9">
                @foreach ($owner->data->user->user->privateActivities as $activity)
                    <span class="badge badge-pill border border-info text-info mt-2">{{ $activity }}</span>
                @endforeach
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-12">
                <h4 class="mb-3">Detalles</h4>
                <h5 class="text-center">Sin información :(</h5>
            </div>
        </div>
    @endif
</div>
