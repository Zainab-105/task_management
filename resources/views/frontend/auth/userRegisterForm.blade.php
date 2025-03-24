<div class="auth-card position-relative">
    <div class="section-title">
        <h1 class="heading-title-h4 fw-bold">{{ __("Sign Up") }}</h1>
    </div>
    <form id="frmUserRegister" autocomplete="off" action="{{ route('frontend.register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-floating position-relative">
                    <select class="form-select" id="role" name="role">
                        <option value="manager">Manager</option>
                        <option value="employee">Employee</option>
                    </select>
                    <label for="role">Select Role</label>
                </div>
                @if ($errors->has('role'))
                    <span class="help-block">
                        <strong class="form-text text-danger">{{ $errors->first('role') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __("Enter name") }}" value="{{ old('name') }}">
                    <label for="name">{{ __("Full name") }}</label>
                </div>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong class="form-text text-danger">{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="{{ __("Email address") }}" value="{{ old('email') }}">
                    <label for="email">{{ __("Email address") }}</label>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong class="form-text text-danger">{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-6">
                <div class="form-floating pass-filed position-relative">
                    <input type="password" class="form-control pass-control" id="vendorPassword" name="password" placeholder="{{ __("password") }}" value="{{ old('password') }}">
                    <label for="password">{{ __("Password") }}</label>
                    <button class="show-pass border-0 bg-transparent p-0"></button>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong class="form-text text-danger">{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-6">
                <div class="form-floating pass-filed position-relative">
                    <input type="password" autocomplete="off" class="form-control pass-control" id="password_confirmation" name="password_confirmation" placeholder="{{ __("Confirm password") }}" value="{{ old('password_confirmation') }}">
                    <label for="password_confirmation">{{ __("Confirm password") }}</label>
                    <button class="show-pass border-0 bg-transparent p-0"></button>
                    <div class="pass-strength-card d-none">
                        <ul class="strength-list">
                            <li class="min">{{ __("8 characters min") }}</li>
                            <li class="capital">{{ __("One Capital letter") }}</li>
                            <li class="special">{{ __("Special character") }}</li>
                            <li class="number">{{ __("At least one number") }}</li>
                        </ul>
                        <div class="strength-progress position-relative">
                            <div class="strength-progress-fill"></div>
                        </div>
                        <div class="d-flex pass-status align-items-center">
                            <div>
                                <p>{{ __("Password Strength") }}</p>
                                <p class="week text-danger">{{ __("Weak") }}</p>
                                <p class="strong d-none">{{ __("Very strong") }}</p>
                            </div>
                            <img src="{{ asset('assets/frontend/images/shield-icon.svg') }}" alt="shield-icon">
                        </div>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong class="form-text text-danger">{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-floating">
            <button type="submit" class="common-btn small-btn w-100"><span class="position-relative d-inline-flex align-items-center">{{ __("Sign Up") }}</button>
        </div>
    </form>
</div>
<p class="text-center big-text dont-account">{{ __("Have an account?") }}
    <a href="{{ route('frontend.login.show') }}" class="common-link fw-bold text-decoration-none">{{ __("Sign In") }}</a>
</p>