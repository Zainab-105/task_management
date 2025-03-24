@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-tasks text-primary"></i>
                </span>
                <h3 class="card-label text-uppercase">View {{ $custom_title }} Details</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="form-group col-md-12 row">
                    <div class="col-md-6">
                        <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Title :</label>
                        <h4>{{ $task->title ?? '--' }}</h4>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Due Date :</label>
                        <h4>{{ $task->due_date ?? '--' }}</h4>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Status :</label>
                        <h4>{{ $task->status ?? '--' }}</h4>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Assigned To :</label>
                        <h4>{{ $task->user->name ?? '--' }}</h4>
                    </div>
                    <div class="col-md-12">
                        <div>
                            <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Description : </label>
                        </div>
                        <div>
                            @if($task->description) <h5>{!! $task->description !!}</h5> @else -- @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
