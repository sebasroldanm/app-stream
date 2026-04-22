<div>
    <div class="d-grid gap-3 d-grid-template-1fr-19">
        @for ($i = 0; $i < 5; $i++)
            <div class="card mb-0 card_owner_home">
                <div class="top-bg-image top-bg-list-owner">
                    <div class="skeleton-placeholder w-100" style="height: 110px; border-radius: 5px 5px 0 0;"></div>
                </div>

                <div class="card-body text-center">
                    <div class="group-icon" style="margin-top: -60px;">
                        <div class="skeleton-placeholder s-round avatar-120" style="border: 4px solid var(--bs-white);">
                        </div>
                    </div>

                    <div class="group-info pt-3 pb-3">
                        <div class="skeleton-placeholder mb-2" style="width: 60%; height: 20px;"></div>
                        <br>
                        <div class="skeleton-placeholder" style="width: 40%; height: 14px;"></div>
                    </div>

                    <div class="group-details d-inline-block pb-3 w-100">
                        <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                            <li class="pe-3 ps-3">
                                <div class="skeleton-placeholder" style="width: 40px; height: 10px;"></div>
                                <div class="skeleton-placeholder" style="width: 25px; height: 15px;"></div>
                            </li>
                            <li class="pe-3 ps-3 border-start border-end">
                                <div class="skeleton-placeholder" style="width: 40px; height: 10px;"></div>
                                <div class="skeleton-placeholder" style="width: 25px; height: 15px;"></div>
                            </li>
                            <li class="pe-3 ps-3">
                                <div class="skeleton-placeholder" style="width: 40px; height: 10px;"></div>
                                <div class="skeleton-placeholder" style="width: 25px; height: 15px;"></div>
                            </li>
                        </ul>
                    </div>

                    <div class="group-member mb-3">
                        <div class="iq-media-group">
                            <div class="skeleton-placeholder s-round me-n2"
                                style="width: 40px; height: 40px; border: 2px solid white;"></div>
                            <div class="skeleton-placeholder s-round me-n2"
                                style="width: 40px; height: 40px; border: 2px solid white;"></div>
                            <div class="skeleton-placeholder s-round"
                                style="width: 40px; height: 40px; border: 2px solid white;"></div>
                        </div>
                    </div>

                    <div class="skeleton-placeholder rounded" style="width: 100%; height: 38px;"></div>
                </div>
            </div>
        @endfor
    </div>
</div>
