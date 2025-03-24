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
                        <label class="control-label">Title:</label>
                        <h4>{{ $task->title ?? '--' }}</h4>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Due Date:</label>
                        <h4>{{ $task->due_date ?? '--' }}</h4>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Status:</label>
                        <h4>{{ $task->status ?? '--' }}</h4>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Assigned To:</label>
                        <h4>{{ $task->user->name ?? '--' }}</h4>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label">Description:</label>
                        <h5>{!! $task->description ?? '--' !!}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- COMMENTS SECTION -->
    <div class="card mt-4">
        <div class="card-header">
            <h4>Comments</h4>
        </div>
        <div class="card-body">
            <!-- Comment List -->
            @foreach ($task->comments as $comment)
                <div class="mb-3 border-bottom pb-2">
                    <strong>{{ $comment->user->name }}</strong> - <small>{{ $comment->created_at->diffForHumans() }}</small>
                    <p>{{ $comment->comment }}</p>
                </div>
            @endforeach

            <!-- Add Comment Form -->
            <form action="{{ route('tasks.comment.store', $task->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Add a Comment</label>
                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>
@endsection
