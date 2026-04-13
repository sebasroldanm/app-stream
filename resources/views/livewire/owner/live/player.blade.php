<div>
    <div class="card bg-dark">
        <video id="live-player{{ $isMultiview ? '-' . $owner->id : '' }}">
        </video>
    </div>
    <div class="overlay-text" id="error-message" style="display: none;">
        Intente más tarde
    </div>
</div>
