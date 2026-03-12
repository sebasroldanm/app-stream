<div>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            <img src="{{ asset('/images/page-img/profile-bg3.jpg') }}" class="img-fluid w-100" alt="header-bg">
            <div class="title-on-header">
                <div class="data-block">
                    <h2>Actions</h2>
                </div>
            </div>
        </div>
    </div>

    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Acciones</h5>
                            <div class="d-grid gap-3 d-grid-template-1fr-19">
                                <button class="btn btn-primary" wire:click="updateOnline" wire:loading.attr="disabled">Actualizar Online</button>
                                <button class="btn btn-primary" wire:click="updateAll" wire:loading.attr="disabled">Actualización completa</button>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-center" wire:loading>
                                <div class="spinner-border text-primary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>