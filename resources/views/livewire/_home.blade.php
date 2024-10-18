<div class="container mt-5">
    <!-- Introducción -->
    <div class="text-center mb-4">
        <h1>Bienvenido a Nuestro Sitio Web</h1>
        <p class="lead">Explora nuestros servicios y productos de alta calidad.</p>
        @if (auth()->guard('customer')->check())
            <code>Bienvenido <strong>{{ auth()->guard('customer')->user()->username }}</strong></code>
        @endif

    </div>

    <hr>
    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-primary" wire:click="moreLimit">Mas Resultados</button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" wire:click="lessLimit">Menos Resultados</button>
        </div>
        <div class="col-md-2">
            <select id="exampleSelect" wire:change="order" wire:model="orderDir" class="form-control">
                <option value="asc">Asecdendente</option>
                <option value="desc">Descendente</option>
            </select>
            {{-- <button class="btn btn-primary" wire:click="order">{{ $textOrder }}</button> --}}
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" placeholder="Buscar..." wire:model="search"
                wire:keyup.debounce.500ms="searchByText">
        </div>
        <div class="col-md-1">
            <button class="btn btn-secondary" wire:click="$refresh">Refrescar</button>
        </div>
    </div>
    <br>

    <div class="row">
        @foreach ($mods as $mod)
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title">{{ $mod->username }}</small>
                        @if ($mod->avatar)
                            <img src="{{ $mod->avatar }}" class="img-fluid avatar" alt="">
                        @else
                            <img src="{{ 'https://placehold.co/300x300?text=No+Imagen' }}" class="img-fluid"
                                alt="">
                        @endif
                        @if ($mod->name)
                        @endif
                        <div class="d-flex justify-content-center mt-1">
                            <a href="/mod/{{ $mod->username }}" class="btn btn-outline-info text-center btn-sm">Ver
                                Perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-primary" wire:click="moreLimit">Mas Resultados</button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" wire:click="lessLimit">Menos Resultados</button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" wire:click="order">{{ $textOrder }}</button>
        </div>
    </div>


    <!-- Párrafo Final -->
    <div class="text-center mt-5">
        <h2>Gracias por visitar nuestra página</h2>
        <p>Estamos comprometidos a ofrecerte la mejor experiencia posible. No dudes en contactarnos si tienes alguna
            pregunta.</p>
    </div>
</div>
@push('styles')
    <style>
        .avatar {
            transition: filter 0.3s ease;
            filter: blur(3px);
        }

        img:hover {
            filter: blur(0px);
        }
    </style>
@endpush
