@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fas fa-tasks text-primary"></i>
                </span>
                <h3 class="card-label text-uppercase">Edit {{ $custom_title }}</h3>
            </div>
        </div>

        <!--begin::Form-->
        <form id="frmEditTask" method="POST" action="{{ route('tasks.update', $task->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body">

                {{-- Title --}}
                <div class="form-group">
                    <label for="title">*Title:</label>
                    <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') != null ? old('title') : $task->title }}" placeholder="Enter title" autocomplete="title" spellcheck="false" autocapitalize="sentences" tabindex="0" autofocus />
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description">*Description:</label>
                    <textarea type="textarea" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter description" autocomplete="description" spellcheck="false" autocapitalize="sentences" tabindex="0" autofocus>{{ old('description') != null ? old('description') : $task->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">*Status:</label>
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                        <option value="" selected></option>
                        @if(auth()->user()->role_id == 2)
                            <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                            <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Closed" {{ $task->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                        @elseif(auth()->user()->role_id == 3 && $task->status == 'Closed')
                            <option value="Closed" {{ $task->status == 'Closed' ? 'selected disabled' : '' }}>Closed</option>
                        @elseif(auth()->user()->role_id == 3)
                            <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                            <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                        @endif
                    </select>
                    @if ($errors->has('status'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                    
                </div>

                {{-- Due Date --}}
                <div class="form-group">
                    <label for="due_date">*Due Date:</label>
                    <input type="text" class="form-control datetimepicker @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') != null ? old('due_date') : $task->due_date }}" placeholder="Select due date" autocomplete="off" />
                    @if ($errors->has('due_date'))
                        <span class="help-block">
                            <strong class="form-text">{{ $errors->first('due_date') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Update {{ $custom_title }}</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection

@push('extra-js')
<script type="text/javascript">
$(document).ready(function () {

    // Date time picker initialization
    $('.datetimepicker').datetimepicker({
    format: 'yyyy-mm-dd HH:mm:ss', // Date and time format
    minDate: moment().startOf('day'), // Disable past dates
    });

    $("#frmEditTask").validate({
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
            status: {
                required: true,
                not_empty: true,
            },
            due_date: {
                required: true,
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
                maxlength:"@lang('validation.max.string',['attribute'=>'description','max'=>250])",
            },
            status: {
                required: "@lang('validation.required',['attribute'=>'status'])",
                not_empty: "@lang('validation.not_empty',['attribute'=>'status'])",
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

    $('#frmEditTask').submit(function (e) {
        if ($(this).valid()) {
            addOverlay();
            $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
            return true;
        } else {
            return false;
        }
    });

    //tell the validator to ignore Summernote elements
    $('form').each(function () {
        if ($(this).data('validator')){
            $(this).data('validator').settings.ignore = ".note-editor *";
        }
    })
});
</script>
@endpush
