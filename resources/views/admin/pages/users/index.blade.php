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
                    <i class="fas fa-users text-primary"></i>
                </span>
                <h3 class="card-label">{{ $custom_title }}</h3>
            </div>

            <div class="card-toolbar">
                @if (in_array('add', $permissions))
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary font-weight-bolder text-uppercase">
                        <i class="fas fa-plus"></i>
                        Add {{ $custom_title }}
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            {{--  Datatable Start  --}}
            <table class="table table-bordered table-hover table-checkable" id="users_table" style="margin-top: 13px !important"></table>
            {{--  Datatable End  --}}
        </div>
    </div>
</div>
@endsection

@push('extra-js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
        var table = $('#users_table');
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
                { "title": "Sr. No.", render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1; }, sortable: false
                },
                { "data": "name" ,"title": "Name"},
                { "data": "email" ,"title": "Email", sortable: false},
                { "data": "created_at" ,"title": "Created At",sortable:false},
                { "data": "role_id" ,"title": "Role",sortable:false},
                @if (in_array('edit', $permissions))
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
                "url": "{{route('users.listing')}}",
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
@endpush
