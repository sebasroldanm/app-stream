<div class="sign-in-from">
    <h1 class="mb-0">{{ __('login.sign_up_title') }}</h1>
    <p>{{ __('login.sign_up_subtitle') }}</p>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="mt-4" method="POST" action="{{ route('customer.signup.submit') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="username">{{ __('login.username') }}</label>
            <input name="username" type="text" class="form-control mb-0" id="username"
                placeholder="{{ __('login.username') }}">
        </div>
        <div class="form-group">
            <label class="form-label" for="email">{{ __('login.email') }}</label>
            <input name="email" type="email" class="form-control mb-0" id="email"
                placeholder="{{ __('login.email') }}">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">{{ __('login.password') }}</label>
            <input name="password" type="password" class="form-control mb-0" id="password"
                placeholder="{{ __('login.password') }}">
        </div>
        <div class="d-inline-block w-100">
            <div class="form-check d-inline-block mt-2 pt-1">
                <input type="checkbox" class="form-check-input" id="customCheck1">
                <label class="form-check-label" for="customCheck1">{{ __('login.i_accept') }} <a
                        href="#">{{ __('login.terms') }}</a></label>
            </div>
            <button type="submit" class="btn btn-primary float-end">{{ __('login.sign_up_button') }}</button>
        </div>
        <div class="sign-info">
            <span class="dark-color d-inline-block line-height-2">{{ __('login.already_have_account') }} <a
                    href="{{ route('login') }}">{{ __('login.sign_in') }}</a></span>
        </div>
    </form>
</div>