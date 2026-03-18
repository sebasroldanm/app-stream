<footer class="iq-footer">
    <button id="scrollToTop" class="btn btn-primary" style="position: fixed; right: 50%; bottom: 5px; display: none;">
        {{ __('footer.scroll_to_top') }}
    </button>
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
