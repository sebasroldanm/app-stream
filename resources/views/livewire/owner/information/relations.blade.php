<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ __('owner/information/relations.title') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Group Details Form -->
                    @if($groupId)
                        <form wire:submit.prevent="save">
                            <h5 class="mb-3">{{ __('owner/information/relations.group_details') }}</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="verifiedCheck" wire:model="verified">
                                        <label class="custom-control-label" for="verifiedCheck">{{ __('owner/information/relations.verified_group') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ __('owner/information/relations.group_description') }}:</label>
                                        <input type="text" class="form-control" wire:model="description" placeholder="Descripción general...">
                                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('owner/information/relations.attributes_json') }}:</label>
                                        <textarea class="form-control" wire:model="relationAttributes" rows="2" placeholder='{"clave": "valor"}'></textarea>
                                        @error('relationAttributes') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-sm btn-info">{{ __('owner/information/relations.update_details') }}</button>
                            </div>
                        </form>
                        <hr>
                    @endif

                    <!-- Add Member Form -->
                    <form wire:submit.prevent="save">
                        <h5 class="mb-3">{{ $groupId ? __('owner/information/relations.add_member') : __('owner/information/relations.create_relation') }}</h5>
                        
                        @if(!$groupId)
                            <!-- Show Group Details input if creating new group -->
                             <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="verifiedCheckNew" wire:model="verified">
                                        <label class="custom-control-label" for="verifiedCheckNew">{{ __('owner/information/relations.verified') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ __('owner/information/relations.description') }}:</label>
                                        <input type="text" class="form-control" wire:model="description" placeholder="Descripción...">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 position-relative">
                                <label>{{ __('owner/information/relations.search_owner') }}:</label>
                                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="{{ __('owner/information/relations.search_placeholder') }}">
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

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" {{ empty($related_owner_id) ? 'disabled' : '' }}>
                                {{ $groupId ? __('owner/information/relations.add_owner') : __('owner/information/relations.create_with_owner') }}
                            </button>
                        </div>
                    </form>

                    <hr>
                    
                    <!-- Members List -->
                    <h5 class="mt-4 mb-3">{{ __('owner/information/relations.members_title') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $memberRelation)
                                    <tr wire:key="member-{{ $memberRelation->id }}">
                                        <td>{{ $memberRelation->owner->id }}</td>
                                        <td><a href="{{ route('owner', $memberRelation->owner->username) }}" target="_blank">{{ $memberRelation->owner->username }}</a></td>
                                        <td>
                                            <button wire:click="removeMember({{ $memberRelation->id }})"
                                                onclick="confirm('{{ __('owner/information/relations.remove_confirm') }}') || event.stopImmediatePropagation()"
                                                class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-line"></i> {{ __('owner/information/relations.remove') }}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            @if($groupId)
                                                {{ __('owner/information/relations.no_members') }}
                                            @else
                                                {{ __('owner/information/relations.no_relations') }}
                                            @endif
                                        </td>
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
