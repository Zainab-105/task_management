<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Task, Role};
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $roles = Role::whereIn('name', ['manager', 'employee'])->pluck('id', 'name');
        $total_tasks = (auth()->user()->role_id == 3) ? Task::where('user_id', auth()->user()->id)->count() : Task::count();
        $counts['manager'] = User::where('role_id', $roles['manager'])->count();
        $counts['employee'] = User::where('role_id', $roles['employee'])->count();

        $counts['manager']    = number_format_short($counts['manager']);
        $counts['employee']   = number_format_short($counts['employee']);
        $counts['task']        = $total_tasks;

        return view('admin.dashboard', compact('counts'))->with(['custom_title' => __('Dashboard')]);
    }
    
}

