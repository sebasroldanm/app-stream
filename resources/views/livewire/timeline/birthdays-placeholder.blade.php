<div>
    <ul class="media-story list-inline m-0 p-0">
        @for ($i = 0; $i < 5; $i++)
            <li class="d-flex mb-4 align-items-center">
                <div class="skeleton-placeholder s-round" style="width: 60px; height: 60px; flex-shrink: 0;">
                </div>

                <div class="stories-data ms-3" style="flex-grow: 1;">
                    <div class="skeleton-placeholder" style="width: 120px; height: 18px; margin-bottom: 8px;">
                    </div>
                    <br>
                    <div class="skeleton-placeholder" style="width: 180px; height: 12px;">
                    </div>
                </div>
            </li>
        @endfor
    </ul>
</div>
