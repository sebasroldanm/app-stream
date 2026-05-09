<div class="card-body p-2">
    <ul class="iq-timeline p-2">
        @for ($i = 0; $i < 6; $i++)
            <li>
                <div class="timeline-dots border-secondary opacity-50"></div>
                
                <div class="d-flex align-items-center justify-content-between">
                    <div class="skeleton-placeholder" style="width: 40%; height: 14px; border-radius: 4px;"></div>
                    
                    <div class="skeleton-placeholder" style="width: 15%; height: 10px; border-radius: 4px;"></div>
                </div>

                <div class="d-inline-block w-100 mt-2">
                    <div class="skeleton-placeholder mb-1" style="width: 90%; height: 12px; border-radius: 4px;"></div>
                    
                    @if($i % 2 == 0)
                        <div class="skeleton-placeholder" style="width: 60%; height: 10px; border-radius: 4px;"></div>
                    @endif
                </div>
            </li>
        @endfor
    </ul>
</div>