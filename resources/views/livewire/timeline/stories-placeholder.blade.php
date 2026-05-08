<div class="col-lg-12">
    <div class="card-body">
        <div class="d-flex">
            @foreach (range(1, 5) as $index)
                <div class="d-flex flex-column align-items-center mx-2">
                    <div class="story-circle-item">
                        <div class="circle-ring">
                            <div class="story-avatar">
                                <div class="skeleton-placeholder s-round"
                                    style="width: 60px; height: 60px; flex-shrink: 0;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="skeleton-placeholder" style="width: 50px; height: 12px;">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>