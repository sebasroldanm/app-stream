<div class="comment-area mt-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="like-block position-relative d-flex align-items-center">
            <div class="d-flex align-items-center">
                <div class="like-data">
                    <div class="dropdown">
                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" role="button">
                            <img src="{{ asset('/images/icon/01.png') }}" class="img-fluid" alt="">
                        </span>
                    </div>
                </div>
                <div class="total-like-block ms-2 me-3">
                    <div class="dropdown">
                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" role="button">
                            {{ $item->likes }} Likes
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
