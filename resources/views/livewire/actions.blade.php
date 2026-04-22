<div class="container" wire:poll.2s="checkNotifications">
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
        @if($message)
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>: {{ $status }}
                <button type="button" class="btn-close" wire:click="$set('message', null)"></button>
            </div>
        </div>
    @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('owner/actions.actions') }}</h5>
                            <div class="d-grid gap-3 d-grid-template-1fr-19">
                                <button class="btn btn-primary" wire:click="updateOnline" wire:loading.attr="disabled">{{ __('owner/actions.update_online') }}</button>
                                <button class="btn btn-primary" wire:click="updateAll" wire:loading.attr="disabled">{{ __('owner/actions.full_update') }}</button>
                                <button class="btn btn-primary" wire:click="updateFavorites" wire:loading.attr="disabled">{{ __('owner/actions.update_favorites') }}</button>
                                <button class="btn btn-primary" wire:click="updateFeed" wire:loading.attr="disabled">{{ __('owner/actions.update_feed') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>