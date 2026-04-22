<footer class="iq-footer">
    <div id="swipeUpContainer" class="swipe-container">
        <button class="swipe-up-btn" aria-label="Volver arriba">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
            <span>{{ __('footer.scroll_to_top') }}</span>
        </button>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#">{{ __('footer.privacy_policy') }}</a></li>
                    <li class="list-inline-item"><a href="#">{{ __('footer.terms_and_conditions') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                Copyright {{ date('Y') }} © | {{ __('footer.made_with_love') }}
            </div>
        </div>
    </div>
</footer>
