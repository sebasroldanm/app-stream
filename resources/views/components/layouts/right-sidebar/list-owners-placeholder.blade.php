<div class="media-height p-3">
    @for ($i = 0; $i < 10; $i++)
        <div class="d-flex align-items-center mb-4">
            <div class="iq-profile-avatar">
                <div class="skeleton-placeholder s-round" style="width: 50px; height: 50px;"></div>
            </div>

            <div class="ms-3 flex-grow-1">
                <div class="skeleton-placeholder" style="width: 80px; height: 15px;"></div>
                <br>
                <div class="skeleton-placeholder" style="width: 50px; height: 10px; margin-top: 5px;"></div>
            </div>
        </div>
    @endfor
</div>
