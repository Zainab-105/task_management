@extends('admin.layouts.app')

@push('extra-css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush

@section('content')
<div class="container">

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fas fa-tasks text-primary"></i>
                </span>
                <h3 class="card-label">{{ $custom_title }}</h3>
            </div>
            <div class="card-toolbar">
                @if (in_array('add', $permissions))
                <a href="javascript:void(0)" name="del_select" id="openFormButton"
                    class="openFormButton btn btn-sm btn-primary font-weight-bolder text-uppercase mr-3 delete_all_link">
                    <i class="fas fas fa-tasks"></i> Assign Task
                </a>
                @endif
                @if (in_array('add', $permissions))
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary font-weight-bolder text-uppercase">
                        <i class="fas fa-plus"></i>
                        Add {{ $custom_title }}
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            {{--  Datatable Start  --}}
            <table class="table table-bordered table-hover table-checkable" id="tasks_table" style="margin-top: 13px !important"></table>
            {{--  Datatable End  --}}
        </div>
    </div>
</div>

<div class="modal fade assignTaskPopup" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Assign Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="give-task" id="give-task" action="javascript:void(0)" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">Select User</label>
                        <select class="form-control" name="user_id" id="user_id">
                            <option selected disabled>--Select User--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="task_id">Select Task</label>
                        <select class="form-control" name="task_id" id="task_id">
                            <option selected disabled>--Select Task--</option>
                            @foreach ($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('extra-js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
        var table = $('#tasks_table');
        oTable = table.dataTable({
            "columnDefs": [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            "processing": true,
            "serverSide": true,
            "language": {
                "lengthMenu": "_MENU_ entries",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left" ></i>',
                    "next": '<i class="fa fa-angle-right" ></i>'
                }
            },
            "columns": [
                { "data": "updated_at" ,"title": "Updated At", visible:false},
                { "data": "title" ,"title": "Title", sortable: true},
                { "data": "due_date" ,"title": "Due Date", sortable: false},
                { "data": "status" ,"title": "Status", sortable:false},
                { "data": "user_id" ,"title": "Assigned To", sortable:false},
                @if (in_array('delete', $permissions) || in_array('edit', $permissions))
                    { "data": "action" ,"title": "Action", searchble: false, sortable:false }
                @endif
            ],
            responsive: false,
            "order": [
                [0, 'desc']
            ],
            "lengthMenu": [
                [10, 20, 50, 100],
                [10, 20, 50, 100]
            ],
            "searching": true,
            "pageLength": 10,
            "ajax": {
                "url": "{{route('tasks.listing')}}",
            },
            drawCallback: function( oSettings ) {
              $('.status-switch').bootstrapSwitch();
              $('.status-switch').bootstrapSwitch('onColor', 'success');
              $('.status-switch').bootstrapSwitch('offColor', 'danger');
              removeOverlay();
            },
            "dom": "lfrtip"
        });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.openFormButton', function() {
            $('.give-task')[0].reset();
            $('.give-task').validate().resetForm();
            $('.assignTaskPopup').modal('show');
        });

        $("#give-task").validate({
            rules: {
                user_id: {
                    required: true,
                },
                task_id: {
                    required: true,
                }
            },
            messages: {
                user_id: {
                    required: "This Field Is Required",
                },
                task_id: {
                    required: "This Field Is Required",
                },
            },
            errorClass: 'invalid-feedback',
            errorElement: 'span',
            highlight: function(element) {
                $(element).addClass('is-invalid');
                $(element).siblings('label').addClass('text-danger'); // For Label
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).siblings('label').removeClass('text-danger');
            },
            errorPlacement: function(error, element) {
                if (element.attr("data-error-container")) {
                    error.appendTo(element.attr("data-error-container"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                // Prevent the default form submission
                event.preventDefault();
                var formData = $(form).serialize(); // Get the form data
                // Make an AJAX POST request to submit the form data
                $.ajax({
                    url: "{{ route('users.assignTask') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        if (response.status == 200) {
                            $('.assignTaskPopup').modal('hide');
                            toastr.success(response.message);
                            if (typeof oTable.draw !== "undefined") {
                                oTable.draw();
                            } else if (typeof oTable.fnDraw !== "undefined") {
                                oTable.fnDraw();
                            }
                        } else {
                            toastr.error(response.message); // Display error message
                        }
                    },
                    error: function(error) {
                        // Handle the error response
                        console.log('Error occurred while submitting the form:', error);
                        toastr.error(
                            'An error occurred while submitting the form. Please try again.'
                        );
                    }
                });
            }
        });
        $('#give-task').submit(function() {
            if ($(this).valid()) {
                addOverlay();
                $("input[type=submit], input[type=button], button[type=submit]").prop("disabled",
                    "disabled");
                return true;
            } else {
                return false;
            }
        });

        $(document).on('click', '.assignTaskPopup', function(event) {
            if (event.target === this) {
                $('.give-task').validate().resetForm();
                $('.assignTaskPopup').modal('hide');
            }
        });

        $('.cancelButton').on('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the cancel button
            $('.give-task').find('.error').remove(); // Remove any existing error messages
            $('.assignTaskPopup').modal('hide');
        });
    });
</script>
@endpush
