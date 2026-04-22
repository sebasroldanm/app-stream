<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-muted opacity-50">{{ __('owner/live/info.goal') }}</h5>
                
                <div class="skeleton-placeholder mb-3" style="width: 70%; height: 20px;"></div>

                <div class="progress mb-3" style="height: 20px; background-color: #f0f0f0;">
                    <div class="skeleton-placeholder w-100 h-100"></div>
                </div>

                <div class="skeleton-placeholder" style="width: 40%; height: 14px;"></div>
                
                <div class="mt-4">
                    <div class="skeleton-placeholder" style="width: 30%; height: 16px; margin-bottom: 8px;"></div>
                    <div class="skeleton-placeholder" style="width: 90%; height: 14px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted opacity-50">{{ __('owner/live/info.status') }}</h5>
                
                <div class="skeleton-placeholder rounded-pill mb-3" style="width: 80px; height: 24px;"></div>

                <div class="d-flex align-items-center mb-3">
                    <h5 class="card-title mb-0 me-2">{{ __('owner/live/info.viewers') }}:</h5>
                    <div class="skeleton-placeholder" style="width: 40px; height: 20px;"></div>
                </div>

                <h5 class="card-title text-muted opacity-50">{{ __('owner/live/info.king') }}</h5>
                <div class="d-flex align-items-center">
                    <div class="skeleton-placeholder s-round me-2" style="width: 15px; height: 15px;"></div>
                    <div class="skeleton-placeholder" style="width: 60%; height: 14px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('owner/live/info.viewing_now') }}</h5>
                <div class="viewers-list">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="d-flex align-items-center mb-2">
                            <div class="skeleton-placeholder me-2" style="width: 100px; height: 12px;"></div>
                            <div class="skeleton-placeholder opacity-50" style="width: 60px; height: 10px;"></div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>