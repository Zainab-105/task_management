 <header>
    <div class="container">
        <nav class="navbar navbar-expand-md p-0">
            <a href="{{ route('frontend.home') }}" class="navbar-brand m-0 p-0"><img src="{{ asset('assets/frontend/images/task_logo.png') }}" alt="logo"></a>
                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="top"></span>
                    <span class="mid"></span>
                    <span class="bot"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav position-relative align-items-center justify-content-end">
                    <li>
                        <ul class="d-md-flex align-items-center auth-links">
                            @guest
                            <li>
                                <a href="{{ route('frontend.login.show') }}" class="d-flex align-items-center nav-link text-capitalize fw-bold justify-content-center justify-content-md-start">
                                    <img src="{{ asset('assets/frontend/images/sign-in-icon.svg') }}" alt="sign-in">{{ __("sign in") }}
                                </a>
                            </li>
                            @endguest
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>