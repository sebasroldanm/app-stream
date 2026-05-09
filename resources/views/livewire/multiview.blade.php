<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>{{ __('sidebar.explore') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Seleccionar Owners ({{ count($selectedOwners) }}/12)</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($liveOwners as $owner)
                                    <button wire:click="toggleOwner({{ $owner->id }})"
                                        class="btn {{ in_array($owner->id, $selectedOwners) ? 'btn-primary' : 'btn-outline-primary' }} btn-sm"
                                        title="{{ $owner->username }}">
                                        {{ $owner->username }}
                                    </button>
                                @empty
                                    <p>No hay owners en vivo disponibles.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-4">
                @foreach ($selectedOwners as $ownerId)
                    @php 
                        $ownerModel = \App\Models\Owner::find($ownerId); 
                        if (isset($ownerModel->data->cam->show)) {
                            $state = $ownerModel->data->cam->show->mode;
                            $type = 'badge border border-red text-red text-bold';
                        }elseif ($ownerModel->data->user->user->isLive) {
                            $state = 'Live';
                            $type = 'badge border border-green text-green text-bold';
                        }else{
                            $state = 'Offline';
                            $type = 'badge border border-red text-red text-bold';
                        }
                    @endphp
                    @if ($ownerModel)
                        <div class="col" wire:key="owner-{{ $ownerId }}">
                            <div class="card h-100 mb-0 shadow-sm border-primary">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center py-2 bg-primary text-white">
                                    <h6 class="mb-0 text-white">{{ $ownerModel->username }}</h6> - <span class="{{ $type }}">{{ $state }}</span>
                                    <button wire:click="toggleOwner({{ $ownerId }})"
                                        class="btn-close btn-close-white btn-sm" aria-label="Close"></button>
                                </div>
                                <div class="card-body p-0 bg-dark" style="min-height: 200px;">
                                    <livewire:owner.live.player :owner="$ownerModel" :isMultiview="true" :key="'player-' . $ownerId" />
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/frontend/multiview.js') }}"></script>
@endpush
