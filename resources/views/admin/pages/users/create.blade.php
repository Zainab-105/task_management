@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fas fa-users text-primary"></i>
                </span>
                <h3 class="card-label text-uppercase">ADD {{ $custom_title }}</h3>
            </div>
        </div>

        <!--begin::Form-->
        <form id="frmAddUser" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- First Name --}}
                <div class="form-group">
                    <label for="name">*Full Name:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" autocomplete="name" spellcheck="false" autocapitalize="words" tabindex="0" autofocus />
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">*Email:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email" autocomplete="email" spellcheck="false" tabindex="0" />
                    @if ($errors->has('email'))
                        <span class="text-danger">
                            <strong class="form-text">{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Role --}}
                <div class="form-group">
                    <label for="role">*Role:</label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" tabindex="0">
                        <option value="">Select Role</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger">
                            <strong class="form-text">{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>


            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2 text-uppercase"> Add {{ $custom_title }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary text-uppercase">Cancel</a>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection

@push('extra-js')
<script>
$(document).ready(function () {
    $("#frmAddUser").validate({
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
                    url: "{{ route('check.email') }}",
                    type: "post",
                    data: {
                        _token: function() {
                            return "{{csrf_token()}}"
                        },
                        type: "user",
                    }
                },
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

    $('#frmAddUser').submit(function () {
        if ($(this).valid()) {
            addOverlay();
            $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
            return true;
        } else {
            return false;
        }
    });
});
</script>
@endpush
