<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- css added -->
    @include('frontend.layouts.includes.css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/before-login.css') }}">

    @stack('page-css')
    <!-- favicon added -->
    @include('frontend.layouts.includes.favicon')

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="bg-white font-jakarta font-normal">
    <!-- header section start -->
    @include('frontend.layouts.includes.header')
    <!-- header section end -->
    <!-- main section start -->
        @yield('content')
    <!-- main section end -->
    <!-- footer section start -->
    @include('frontend.layouts.includes.footer')
    <!-- footer section end -->
    <!-- js added -->
    <script>
        
    </script>
    @include('frontend.layouts.includes.js')
    @stack('page-js')
</body>
</html>
