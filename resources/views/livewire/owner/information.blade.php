<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                    <li>
                        <a class="nav-link @if ($showPanel) active @endif" href="#v-pills-profile"
                            wire:click="loadComponent('panel')"
                            data-bs-toggle="pill" data-bs-target="#v-profile" role="button">Pannels (Perfil)</a>
                    </li>
                    <li>
                        <a class="nav-link @if ($showDetail) active @endif" href="#v-pills-details-tab"
                            wire:click="loadComponent('detail')"
                            data-bs-toggle="pill" data-bs-target="#v-pills-details-tab" role="button">Detalles</a>
                    </li>
                    <li>
                        <a class="nav-link @if ($showSnapshots) active @endif" href="#v-pills-snapshots-tab"
                            wire:click="loadComponent('snapshots')"
                            data-bs-toggle="pill" data-bs-target="#v-pills-snapshots-tab" role="button">Instantáneas</a>
                    </li>
                    @if ($owner->isInfoCustom)
                        <li>
                            <a class="nav-link @if ($showInfoCustom) active @endif" href="#v-infocustom-tab"
                                wire:click="loadComponent('info-custom')"
                                data-bs-toggle="pill" data-bs-target="#v-infocustom" role="button">Información
                                personalizada</a>
                        </li>
                    @endif
                    @if ($owner->isMediaCustom)
                        <li>
                            <a class="nav-link @if ($showMediaCustom) active @endif"
                                wire:click="loadComponent('media-custom')"
                                href="#v-pills-mediacustom-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-mediacustom-tab" role="button">Multimedia personalizada</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-9 ps-4">
                <div class="tab-content">
                    <div class="tab-pane fade @if ($showPanel) show active @endif" id="v-pills-profile"
                        role="tabpanel" aria-labelledby="v-pills-profile">
                        @if ($showPanel)
                            @livewire('owner.information.panel', ['owner' => $owner])
                        @endif
                    </div>

                    <div class="tab-pane fade @if ($showDetail) show active @endif" id="v-pills-details"
                        role="tabpanel" aria-labelledby="v-pills-details">
                        @if ($showDetail)
                            @livewire('owner.information.detail', ['owner' => $owner])
                        @endif
                    </div>

                    <div class="tab-pane fade @if ($showSnapshots) show active @endif" id="v-pills-snapshots"
                        role="tabpanel" aria-labelledby="v-pills-snapshots">
                        @if ($showSnapshots)
                            @livewire('owner.information.snapshots', ['owner' => $owner])
                        @endif
                    </div>

                    <div class="tab-pane fade @if ($showInfoCustom) show active @endif"
                        id="v-pills-infocustom" role="tabpanel" aria-labelledby="v-pills-infocustom">
                        @if ($showInfoCustom)
                            @livewire('owner.information.info-custom', ['owner' => $owner])
                        @endif
                    </div>

                    <div class="tab-pane fade @if ($showMediaCustom) show active @endif"
                        id="v-pills-mediacustom" role="tabpanel" aria-labelledby="v-pills-mediacustom">
                        @if ($showMediaCustom)
                            @livewire('owner.information.media-custom', ['owner' => $owner])
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
