<div>
    <div class="row">
        @for ($i = 0; $i < 18; $i++)
            <div class="col-4 col-md-3 col-lg-2">
                <div style="width: auto; flex: 1;">
                    <div class="user-post-data position-relative">
                        <div class="image-container overflow-hidden rounded shadow-sm position-relative">
                            <div class="skeleton-placeholder w-100" style="height: 180px; display: block;"></div>

                            <div class="position-absolute top-0 start-0 m-1">
                                <div class="skeleton-placeholder"
                                    style="width: 25px; height: 18px; border-radius: 4px; opacity: 0.6;"></div>
                            </div>
                        </div>

                        <div class="mt-2 text-center">
                            <div class="skeleton-placeholder" style="width: 70%; height: 14px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
