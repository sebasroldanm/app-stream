<div class="sign-in-from">
    <h1 class="mb-0">{{ __('login.sign_in') }}</h1>
    <p>{{ __('login.subtitle') }}</p>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="mt-4" method="POST" action="{{ route('customer.login.submit') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">{{ __('login.email') }}</label>
            <input name="email" type="email" class="form-control mb-0" id="email"
                placeholder="{{ __('login.email') }}">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">{{ __('login.password') }}</label>
            <a href="#" class="float-end">{{ __('login.forgot') }}</a>
            <input name="password" type="password" class="form-control mb-0" id="password"
                placeholder="{{ __('login.password') }}">
        </div>
        <div class="d-inline-block w-100">
            <div class="form-check d-inline-block mt-2 pt-1">
                <input type="checkbox" class="form-check-input" id="customCheck11">
                <label class="form-check-label" for="customCheck11">{{ __('login.remember') }}</label>
            </div>
            <button type="submit" class="btn btn-primary float-end">{{ __('login.sign_in') }}</button>
        </div>
        <div class="sign-info">
            <span class="dark-color d-inline-block line-height-2">{{ __('login.dont_have_account') }} <a
                    href="{{ route('customer.signup') }}">{{ __('login.sign_up') }}</a></span>
        </div>
    </form>
</div>

