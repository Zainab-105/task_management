@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-user-edit text-primary"></i>
                </span>
                <h3 class="card-label text-uppercase">Edit {{ $custom_title }}</h3>
            </div>
        </div>

        <!--begin::Form-->
        <form id="frmEditUser" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body">

                {{-- Full Name --}}
                <div class="form-group">
                    <label for="name">*First Name:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') != null ? old('name') : $user->name }}" placeholder="Enter first name" autocomplete="name" spellcheck="false" autocapitalize="sentences" tabindex="0" autofocus />
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">*Email:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') != null ? old('email') : $user->email }}" placeholder="Enter email" autocomplete="email" spellcheck="false" tabindex="0" />
                    @if ($errors->has('email'))
                        <span class="text-danger">
                            <strong class="form-text">{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Role --}}
                <div class="form-group">
                    <label for="role">*Role:</label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                        <option value="">Select Role</option>
                        <option value="manager" {{ old('role') == 'manager' || $user->roles->first()->name == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="employee" {{ old('role') == 'employee' || $user->roles->first()->name == 'employee' ? 'selected' : '' }}>Employee</option>
                    </select>
                    @if ($errors->has('role'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Update {{ $custom_title }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection

@push('extra-js')
<script>
$(document).ready(function () {
    $("#frmEditUser").validate({
        rules: {
            name: {
                required: true,
                not_empty: true,
                minlength: 3,
            },
            email: {
                required: true,
                maxlength: 80,
                email: true,
                valid_email: true,
            },
            role: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "@lang('validation.required',['attribute'=>'first name'])",
                not_empty: "@lang('validation.not_empty',['attribute'=>'first name'])",
                minlength:"@lang('validation.min.string',['attribute'=>'first name','min'=>3])",
            },
            email: {
                required: "@lang('validation.required',['attribute'=>'email address'])",
                maxlength:"@lang('validation.max.string',['attribute'=>'email address','max'=>80])",
                email:"@lang('validation.email',['attribute'=>'email address'])",
                valid_email:"@lang('validation.email',['attribute'=>'email address'])",
            },
            role: {
                required: "@lang('validation.required',['attribute'=>'role'])",
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
            $(element).siblings('label').removeClass('text-danger');
        },
        errorPlacement: function (error, element) {
            if (element.attr("data-error-container")) {
                error.appendTo(element.attr("data-error-container"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    $('#frmEditUser').submit(function () {
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
