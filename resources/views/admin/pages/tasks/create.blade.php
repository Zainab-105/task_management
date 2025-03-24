@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fas fa-tasks text-primary"></i>
                </span>
                <h3 class="card-label text-uppercase">ADD {{ $custom_title }}</h3>
            </div>
        </div>

        <!--begin::Form-->
        <form id="frmAddTask" method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- Title --}}
                <div class="form-group">
                    <label for="title">*Title:</label>
                    <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter title" autocomplete="title" spellcheck="false" autocapitalize="sentences" tabindex="0" autofocus />
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Due Date --}}
                <div class="form-group">
                    <label for="due_date">*Due Date:</label>
                    <input type="text"
                        class="datepicker form-control @error('due_date') is-invalid @enderror"
                        id="due_date" name="due_date"
                        value="{{ is_array(old('due_date')) }}" placeholder="-Select Due Date-"
                        autocomplete="due_date" spellcheck="false" autocapitalize="sentences"
                        tabindex="0" autofocus />
                    @error('due_date')
                        <span class="invalid-feedback" role="alert">
                            <strong class="form-text">{{ $errors->first('due_date') }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description">*Description:</label>
                    <textarea type="textarea" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter description" autocomplete="description" spellcheck="false" autocapitalize="sentences" tabindex="0" autofocus>{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2 text-uppercase"> Add {{ $custom_title }}</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary text-uppercase">Cancel</a>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection

@push('extra-js')
<script>
$(document).ready(function () {

    $('.datepicker').datetimepicker({
    format: 'yyyy-mm-dd HH:mm:ss', // Date and time format
    minDate: moment().startOf('day'), // Disable past dates
    });

    // $.validator.addMethod("noPastDate", function(value, element) {
    //     var selectedDate = moment(value, 'YYYY-MM-DD HH:mm:ss');
    //     var currentDate = moment().startOf('day');
    //     return selectedDate >= currentDate; // Return true if selected date is greater than or equal to current date
    // }, "Past dates are not allowed");

    $("#frmAddTask").validate({
        rules: {
            title: {
                required: true,
                not_empty: true,
                minlength: 3,
                maxlength: 250,
            },
            description: {
                required: true,
                not_empty: true,
                minlength: 3,
                maxlength: 250,
            },
            due_date: {
                required: true,
                // noPastDate: true,
            },
        },
        messages: {
            title: {
                required: "@lang('validation.required',['attribute'=>'title'])",
                not_empty: "@lang('validation.not_empty',['attribute'=>'title'])",
                minlength:"@lang('validation.min.string',['attribute'=>'title','min'=>3])",
                maxlength:"@lang('validation.max.string',['attribute'=>'title','max'=>250])",
            },
            description: {
                required: "@lang('validation.required',['attribute'=>'description'])",
                not_empty: "@lang('validation.not_empty',['attribute'=>'description'])",
                minlength:"@lang('validation.min.string',['attribute'=>'description','min'=>3])",
                maxlength:"@lang('validation.max.string',['attribute'=>'title','max'=>250])",
            },
            due_date: {
                required: "@lang('validation.required',['attribute'=>'due date'])",
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

    $('#frmAddTask').submit(function (e) {
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
