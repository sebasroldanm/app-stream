<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Relaciones entre Owners</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12 position-relative">
                                <label>Buscar Owner:</label>
                                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre o email...">
                                @if(!empty($searchResults))
                                    <div class="list-group position-absolute w-100" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                        @foreach($searchResults as $result)
                                            <button type="button" class="list-group-item list-group-item-action" wire:click="selectOwner({{ $result->id }})">
                                                {{ $result->username }} <small class="text-muted">({{ $result->id }})</small>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                                @error('related_owner_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="verifiedCheck" wire:model="verified">
                                    <label class="custom-control-label" for="verifiedCheck">Verificado</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Descripción:</label>
                                    <input type="text" class="form-control" wire:model="description" placeholder="Descripción de la relación...">
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Atributos (JSON):</label>
                                    <textarea class="form-control" wire:model="relationAttributes" rows="2" placeholder='{"clave": "valor"}'></textarea>
                                    @error('relationAttributes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                {{ $editingRelationId ? 'Actualizar Relación' : 'Agregar Relación' }}
                            </button>
                            @if($editingRelationId)
                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary ml-2">
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    </form>

                    <hr>

                    <div class="table-responsive mt-4">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Verificado</th>
                                    <th>Descripción</th>
                                    <th>Atributos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($relations as $relation)
                                    <tr wire:key="relation-{{ $relation->id }}">
                                        <td>{{ $relation->relatedOwner->id }}</td>
                                        <td><a href="{{ route('owner', $relation->relatedOwner->username) }}" target="_blank">{{ $relation->relatedOwner->username }}</a></td>
                                        <td>
                                            @if($relation->verified)
                                                <span class="badge badge-pill border border-success text-success">Sí</span>
                                            @else
                                                <span class="badge badge-pill border border-danger text-danger">No</span>
                                            @endif
                                        </td>
                                        <td>{{ $relation->description ?? '-' }}</td>
                                        <td>
                                            @if($relation->attributes)
                                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ json_encode($relation->attributes) }}">
                                                    {{ json_encode($relation->attributes) }}
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="edit({{ $relation->id }})" class="btn btn-sm btn-info mr-1">
                                                <i class="ri-pencil-line"></i>
                                            </button>
                                            <button wire:click="delete({{ $relation->id }})"
                                                onclick="confirm('¿Estás seguro de eliminar esta relación?') || event.stopImmediatePropagation()"
                                                class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay relaciones registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
