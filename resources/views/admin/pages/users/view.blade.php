@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fas fa-users text-primary"></i>
                </span>
                <h3 class="card-label text-uppercase">View {{ $custom_title }} Details</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row pl-5">
                    <div class="form-group col-md-12 row">
                        <div class="form-group col-md-6">
                            <div class="mb-2">
                                <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Full Name : <h4>
                                    @if($user->name) {{ $user->name }} @else -- @endif
                                </h4></label>
                            </div>
                            <div class="mb-2">
                                <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Email : <h4>
                                    @if($user->email) {{ $user->email }} @else -- @endif
                                </h4></label>
                            </div>
                            <div class="mb-2">
                                <label class="control-label"><span class="mendatory" style="font-size: 25px;"></span>Role : <h4>
                                    @if($user->roles->first()->name) {{ ucfirst($user->roles->first()->name) }} @else -- @endif
                                </h4></label>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
