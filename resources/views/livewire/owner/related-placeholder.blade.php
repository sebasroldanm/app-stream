<div class="card card-block card-stretch card-height">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="header-title">
            <div class="skeleton-placeholder" style="width: 150px; height: 22px;"></div>
        </div>
        <div class="card-header-toolbar d-flex align-items-center">
            <div class="skeleton-placeholder rounded" style="width: 35px; height: 30px;"></div>
        </div>
    </div>
    <div class="card-body">
        <div class="related-models-wrapper position-relative px-5">
            <div class="d-flex overflow-hidden" style="gap: 15px;">
                @for ($i = 0; $i < 5; $i++) 
                    <div style="min-width: 150px; flex: 1;">
                        <div class="user-post-data position-relative">
                            <div class="image-container overflow-hidden rounded shadow-sm position-relative">
                                <div class="skeleton-placeholder w-100" style="height: 180px; display: block;"></div>
                                
                                <div class="position-absolute top-0 start-0 m-1">
                                    <div class="skeleton-placeholder" style="width: 25px; height: 18px; border-radius: 4px; opacity: 0.6;"></div>
                                </div>
                            </div>
                            
                            <div class="mt-2 text-center">
                                <div class="skeleton-placeholder" style="width: 70%; height: 14px; margin-bottom: 5px;"></div>
                                <div class="skeleton-placeholder" style="width: 30%; height: 10px;"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="custom-arrow" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); opacity: 0.3;">
                <i class="ri-arrow-right-s-line h3"></i>
            </div>
            <div class="custom-arrow" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); opacity: 0.3;">
                <i class="ri-arrow-left-s-line h3"></i>
            </div>
        </div>
    </div>
</div>