@extends('frontend.layouts.auth')
@section('title', 'Task Management | Login')
@section('content')
<!-- main section start -->
<main>
    <section class="auth-sec position-relative">
        <div class="container">
            <div class="auth-tab position-relative">
                <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link position-relative active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home" type="button" role="tab" aria-controls="home"
                            aria-selected="true"><img src="{{ asset('assets/frontend/images/user-login-icon.svg') }}"
                                alt="user-login-icon"></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @include('frontend.auth.userLoginForm')
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- main section end -->
@endsection
@push('page-js')
<script src="{{ asset('assets/admin/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/plugins/jquery-validation/js/additional-methods.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/js/custom_validations.js') }}"></script>
@endpush
