<div class="auth-card position-relative">
    <div class="section-title">
        <h1 class="heading-title-h4 fw-bold">{{ __("User login") }}</h1>
    </div>
    <form id="frmUserLogin" action="{{ route('frontend.login') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="{{ old('email') }}">
            <label for="email">{{ __("Email address") }}</label>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong class="form-text text-danger">{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-floating pass-filed position-relative">
            <input type="password" class="form-control" id="password" name="password" placeholder="password" value="{{ old('password') }}">
            <label for="password">{{ __("Password") }}</label>
            <button class="show-pass border-0 bg-transparent p-0"></button>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong class="form-text text-danger">{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        {{-- <div class="form-floating text-end forgot-text">
            {{ __("Forgot password ?") }}
            <a href="{{ route('frontend.password.reset') }}" class="common-link fw-bold">{{ __("Click here") }}</a> {{ __("to reset") }}
        </div> --}}
        <div class="form-floating">
            <button type="submit" class="common-btn small-btn w-100">
                <span class="position-relative d-inline-flex align-items-center">{{ __("Sign In") }}
                    <img src="{{ asset('assets/frontend/images/login-btn-icon.svg') }}" alt="login-btn-icon">
                </span>
            </button>
        </div>
    </form>
</div>
<p class="text-center big-text dont-account">
    {{ __("Dont have an account ?") }}
    <a href="{{ route('frontend.register.show') }}" class="common-link fw-bold text-decoration-none">{{ __("Sign Up") }}</a>
</p>