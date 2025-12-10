<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Información Personalizada</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row align-items-center">
                            <div class="form-group col-sm-4">
                                <label>Tipo:</label>
                                <select class="form-control" wire:model.live="info_type_id">
                                    <option value="">Seleccione...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->label }}</option>
                                    @endforeach
                                </select>
                                @error('info_type_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Fuente:</label>
                                @if ($this->selectedTypeModel && in_array($this->selectedTypeModel->data_type, ['file', 'json']))
                                    <select class="form-control" wire:model="source_id">
                                        <option value="">(Opcional)</option>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('source_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <input placeholder="No disponible" disabled>
                                @endif
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Valor:</label>
                                @if ($this->selectedTypeModel && $this->selectedTypeModel->data_type === 'file')
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" wire:model="data_value" id="customFile">
                                        <label class="custom-file-label" for="customFile">Elegir archivo</label>
                                    </div>
                                    @if ($data_value)
                                        <small class="text-success">Archivo seleccionado: {{ $data_value->getClientOriginalName() }}</small>
                                    @endif
                                @elseif($this->selectedTypeModel && $this->selectedTypeModel->data_type === 'number')
                                     <input type="number" class="form-control" wire:model="data_value" placeholder="12345...">
                                @elseif($this->selectedTypeModel && $this->selectedTypeModel->data_type === 'url')
                                     <input type="url" class="form-control" wire:model="data_value" placeholder="https://ejemplo.com">
                                @else
                                    <input type="text" class="form-control" wire:model="data_value" placeholder="Valor...">
                                @endif

                                @error('data_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Fuente</th>
                                    <th>Valor</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customInfos as $info)
                                    <tr>
                                        <td>{{ $info->type->label }}</td>
                                        <td>{{ $info->source ? $info->source->name : '-' }}</td>
                                        <td>
                                            @if (is_array($info->data_info) && isset($info->data_info['value']))
                                                @if ($info->type->data_type === 'url')
                                                    <a href="{{ $info->data_info['value'] }}" target="_blank">{{ Str::limit($info->data_info['value'], 30) }}</a>
                                                @elseif($info->type->data_type === 'file')
                                                    <a href="{{ Storage::url($info->data_info['value']) }}" target="_blank" class="badge badge-info">
                                                        Ver Archivo
                                                    </a>
                                                    {{-- Optional: Preview if image --}}
                                                    <img src="{{ Storage::url($info->data_info['value']) }}" width="50" />
                                                @else
                                                    {{ Str::limit($info->data_info['value'], 50) }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="delete({{ $info->id }})"
                                                class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay información personalizada
                                            registrada.</td>
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
