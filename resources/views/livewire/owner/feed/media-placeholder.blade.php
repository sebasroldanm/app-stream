<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="skeleton-placeholder" style="width: 40%; height: 15px;"></div>
        <div class="skeleton-placeholder" style="width: 30%; height: 15px;"></div>
    </div>
    <div class="card-body">
        <ul class="profile-img-gallary p-0 m-0 list-unstyled">
            @for ($i = 0; $i < 6; $i++)
                <li class="feed-bg-lists container-overlay">
                    <div class="skeleton-placeholder mb-2" style="width: 100%; height: 100%;"></div>
                </li>
            @endfor
        </ul>
    </div>
</div>
