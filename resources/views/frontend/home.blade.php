@extends('frontend.layouts.app')
@section('title', 'Task Management | Home')

@section('content')
    <!-- main section start -->
    <main>
        <!-- banner section start -->
        <section class="common-banner small-banner  position-relative bg-img d-flex justify-content-center align-items-center" style="background-image: url({{ asset('assets/frontend/images/task_banner.jpg') }});">
            <div class="container position-relative text-center">
                <h1 class="white-text heading-title-h1 d-inline-flex align-items-center">{{ __("Let's Manage Tasks") }} <img src="{{ asset('assets/frontend/images/task_image.jpg') }}" alt="blog-icon"></h1>
            </div>
        </section>
        <!-- banner section end -->
    </main>
    <!-- main section end -->
@endsection
