<div class="card">
    <div class="card-body">
        <div class="row">
            {{-- Sidebar con tabs --}}
            <div class="col-md-3">
                <ul class="nav nav-pills flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'detail' ? 'active' : '' }}"
                           wire:click="loadComponent('detail')" role="button">
                            Detalles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'panel' ? 'active' : '' }}"
                           wire:click="loadComponent('panel')" role="button">
                            Panel (Perfil)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'snapshots' ? 'active' : '' }}"
                           wire:click="loadComponent('snapshots')" role="button">
                            Instantáneas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'similarity' ? 'active' : '' }}"
                           wire:click="loadComponent('similarity')" role="button">
                            Similitud IA
                        </a>
                    </li>
                    {{-- @if ($owner->isInfoCustom) --}}
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'info-custom' ? 'active' : '' }}"
                               wire:click="loadComponent('info-custom')" role="button">
                                Información personalizada
                            </a>
                        </li>
                    {{-- @endif --}}
                    @if ($owner->isMediaCustom)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'media-custom' ? 'active' : '' }}"
                               wire:click="loadComponent('media-custom')" role="button">
                                Multimedia personalizada
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Contenido de tabs --}}
            <div class="col-md-9 ps-4">
                <div class="tab-content">
                    @if ($activeTab === 'detail')
                        @livewire('owner.information.detail', ['owner' => $owner], key('detail-'.$owner->id))
                    @elseif ($activeTab === 'panel')
                        @livewire('owner.information.panel', ['owner' => $owner], key('panel-'.$owner->id))
                    @elseif ($activeTab === 'snapshots')
                        @livewire('owner.information.snapshots', ['owner' => $owner], key('snapshots-'.$owner->id))
                    @elseif ($activeTab === 'similarity')
                        @livewire('owner.information.similarity', ['owner' => $owner], key('similarity-'.$owner->id))
                    @elseif ($activeTab === 'info-custom')
                        @livewire('owner.information.info-custom', ['owner' => $owner], key('info-custom-'.$owner->id))
                    @elseif ($activeTab === 'media-custom' && $owner->isMediaCustom)
                        @livewire('owner.information.media-custom', ['owner' => $owner], key('media-custom-'.$owner->id))
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
