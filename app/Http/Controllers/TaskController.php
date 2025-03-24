<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskRequest;
use App\Models\{User,Task};
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{DB, Hash, Storage,Auth};
use Spatie\Permission\Models\Role;
use Exception;
use App\Jobs\SendTaskAssignedNotificationJob;

class TaskController extends Controller
{
    public function index()
    {
        $users = User::where('role_id',3)->get();
        $tasks = Task::whereNull('user_id')->get();
        return view('admin.pages.tasks.index', compact('users', 'tasks'))->with(['custom_title' => 'Tasks']);
    }

    public function create()
    {
        return view('admin.pages.tasks.create')->with(['custom_title' => 'Task']);
    }

    public function store(TaskRequest $request)
    {
        $details = $request->all();
        $task = Task::create($details);

        if( $task->save() ) {
            flash('Task created successfully!')->success();
        } else {
            flash('Unable to save task. Please try again later.')->error();
        }
        return redirect(route('tasks.index'));
    }

    public function show(Task $task)
    {
        $task = Task::with(['user:id,name', 'comments.user:id,name'])->whereId($task->id)->first();
        return view('admin.pages.tasks.view', compact('task'))->with(['custom_title' => 'Task']);
    }
    
    public function storeComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
    
        $task->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
    
        return back()->with('success', 'Comment added successfully!');
    }
    

    public function edit(Task $task)
    {
        return view('admin.pages.tasks.edit', compact('task'))->with(['custom_title' => 'Task']);
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            DB::beginTransaction();
            
            $details =  $request->all();
            $task->fill($details);

            if( $task->save() ) {
                DB::commit();
                flash('Task details updated successfully!')->success();
            } else {
                flash('Unable to update task. Try again later')->error();
            }
            return redirect(route('tasks.index'));
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->flash('error', $e->getMessage());
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request,$id)
    {   
        $task = Task::whereId($id)->delete();
        if(request()->ajax()){
            $content = array('status' => Response::HTTP_OK, 'message'=>"Task deleted successfully.", 'count' => Task::all()->count());
            return response()->json($content);
        }else{
            flash('Task deleted successfully.')->success();
            return redirect()->route('tasks.index');
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $records = [];
        $userRoleId = Auth::user()->role_id;
        $tasks = Task::query();

        if ($userRoleId === 3) {
            $tasks->where('user_id', auth()->user()->id);
        }

        $tasks = $tasks->orderBy($sort_column, $sort_order);

        if ($search != '') {
            $tasks->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $count = $tasks->count();
        $records['recordsTotal'] = $count;
        $records['recordsFiltered'] = $count;
        $records['data'] = [];

        $tasks = $tasks->offset($offset)->limit($limit)->orderBy($sort_column, $sort_order)->latest()->get();
        foreach ($tasks as $task) {
            $records['data'][] = [
                'id'            =>  $task->id,
                'title'         =>  $task->title ?? "--",
                'due_date'      =>  $task->due_date ? $task->due_date->format('d-m-Y') : "--",
                'status'        =>  $task->status ?? "--",
                'user_id'       =>  $task->user ? $task->user->name : "-Not Assigned-",
                'action'        =>  view('admin.layouts.includes.actions')->with(['custom_title' => 'Task', 'id' => $task->id], $task)->render(),
            ];
        }
        return $records;
    }

    public function userAssignTask(Request $request)
    {
        $task = Task::whereId($request->task_id)->first();
        $task->update([
            'user_id' => $request->user_id,
        ]);
        //Send Email Notification for new task assigned to you
        SendTaskAssignedNotificationJob::dispatch($task);
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Task has been assigned to user and they will be notified via email'
        ]);
    }
}
