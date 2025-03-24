<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management | Login</title>
    <!-- css added -->
    @include('frontend.layouts.includes.css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/before-login.css') }}">

    @stack('page-css')
    <!-- favicon added -->
    @include('frontend.layouts.includes.favicon')

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>
<body class="bg-white font-jakarta font-normal">
    <!-- header section start -->
    @include('frontend.layouts.includes.header')
    <!-- header section end -->
    <!-- main section start -->
    @yield('content')
    <!-- main section end -->
    <!-- js added -->
    <script>
        
    </script>
    @include('frontend.layouts.includes.js')
    @stack('page-js')
    <script>

        // User login
        $("#frmUserLogin").validate({
            rules: {
                email: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    maxlength: 255,
                    email: true,
                    valid_email: true,
                    no_space: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 16,
                    no_space: true,
                },
            },
            messages: {
                email: {
                    required: "@lang('validation.required',['attribute'=> __('email address')])",
                    maxlength:"@lang('validation.max.string',['attribute'=> __('email address'),'max'=>255])",
                    email:"@lang('validation.email',['attribute'=> __('email address')])",
                    valid_email:"@lang('validation.email',['attribute'=> __('email address')])",
                    no_space: "@lang('validation.no_space',['attribute' => __('email address')])",
                },
                password: {
                    required: "@lang('validation.required',['attribute'=> __('password')])",
                    minlength:"@lang('validation.min.string',['attribute'=> __('password'),'min'=>8])",
                    maxlength: "@lang('validation.max.string',['attribute' => __('password'),'max' => 16])",
                    no_space: "@lang('validation.no_space',['attribute' => __('password')])",
                },
            },
            errorClass: 'invalid-feedback',
            errorElement: 'span',
            highlight: function (element) {
                $(element).addClass('is-invalid');
                $(element).siblings('label').addClass('text-danger'); // For Label
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
                $(element).siblings('label').removeClass('text-danger'); // For Label
            },
            errorPlacement: function (error, element) {
                if (element.attr("data-error-container")) {
                    error.appendTo(element.attr("data-error-container"));
                } else {
                    error.insertAfter(element);
                }
            }
        });
        
        $('#frmUserLogin').submit(function () {
            if ($(this).valid()) {
                // $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                return true;
            } else {
                return false;
            }
        });

        // User registration
        $("#frmUserRegister").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    no_space: false,
                    lettersonly: false,
                },
                email: {
                    required: {
                        depends:function(){
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    maxlength: 255,
                    email: true,
                    valid_email: true,
                    no_space: true,
                    remote: {
                        url: "{{ route('frontend.check.user.email') }}",
                        type: "post",
                        data: {
                            _token: function() {
                                return "{{csrf_token()}}"
                            },
                            type: "user",
                        }
                    },
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 16,
                    no_space: true,
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    maxlength: 16,
                    no_space: true,
                    equalTo: "#vendorPassword",
                },
                role: {
                    required: true 
                }
            },
            messages: {
                name: {
                    required: "@lang('validation.required',['attribute'=>  __('name')])",
                    minlength:"@lang('validation.min.string',['attribute'=>  __('name'),'min'=>3])",
                    maxlength: "@lang('validation.max.string',['attribute' =>  __('name'),'max' => 150])",
                    no_space: "@lang('validation.no_space',['attribute' => __('name')])",
                    lettersonly: "@lang('validation.lettersonly',['attribute' => __('name')])",
                },
                email: {
                    required: "@lang('validation.required',['attribute'=> __('email address')])",
                    maxlength:"@lang('validation.max.string',['attribute'=> __('email address'),'max'=>255])",
                    email:"@lang('validation.email',['attribute'=> __('email address')])",
                    valid_email:"@lang('validation.email',['attribute'=> __('email address')])",
                    no_space: "@lang('validation.no_space',['attribute' => __('email address')])",
                    remote:"@lang('validation.unique',['attribute'=> __('email address')])",
                },
                password: {
                    required: "@lang('validation.required',['attribute'=> __('password')])",
                    minlength:"@lang('validation.min.string',['attribute'=> __('password'),'min'=>8])",
                    maxlength: "@lang('validation.max.string',['attribute' => __('password'),'max' => 16])",
                    no_space: "@lang('validation.no_space',['attribute' => __('password')])",
                },
                password_confirmation: {
                    required: "@lang('validation.required',['attribute'=> __('confirm password')])",
                    minlength:"@lang('validation.min.string',['attribute'=> __('confirm password'),'min'=>8])",
                    maxlength: "@lang('validation.max.string',['attribute' => __('confirm password'),'max' => 16])",
                    no_space: "@lang('validation.no_space',['attribute' => __('confirm password')])",
                    equalTo: "@lang('validation.same',['attribute' => __('password'),'other' => __('confirm password')])",
                },
                role: {
                    required: "@lang('validation.required',['attribute'=> __('role')])" 
                }
            },
            errorClass: 'invalid-feedback',
            errorElement: 'span',
            highlight: function (element) {
                $(element).addClass('is-invalid');
                $(element).siblings('label').addClass('text-danger'); // For Label
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
                $(element).siblings('label').removeClass('text-danger'); // For Label
            },
            errorPlacement: function (error, element) {
                if (element.attr("data-error-container")) {
                    error.appendTo(element.attr("data-error-container"));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#frmUserRegister').submit(function () {
            if ($(this).valid()) {
                // $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                return true;
            } else {
                return false;
            }
        });

    </script>
</body>
</html>
