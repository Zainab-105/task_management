<?php

namespace App\Http\ViewComposers;

use Throwable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/**
 * To Manage View Details
 */
class AdminComposer
{
    protected array $permissions = [];
    protected array $module_permissions = [];

    public function __construct()
    {
        $role_id = Auth::user()->role_id;
        $permissionIds = DB::table('role_has_permissions')
                ->where('role_id', $role_id)
                ->distinct() 
                ->pluck('permission_id')->toArray();
        $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $transformedPermissions = [];
        $modulePermissions = [];

        foreach ($permissions as $permission) {
            $permission = str_replace(['-task', '-user'], '', $permission);
            switch ($permission) {
                case 'create':
                    $permission = 'add';
                    break;
                case 'read':
                    $permission = 'view';
                    break;
                case 'update':
                    $permission = 'edit';
                    break;
            }
            $transformedPermissions[] = $permission;
        }
        $this->permissions = $transformedPermissions;

        switch ($role_id) {
            case 1: // Admin
                $modulePermissions[] = 'task_management';
                $modulePermissions[] = 'user_management';
                break;
            case 2: // Manager
                $modulePermissions[] = 'task_management';
                break;
            case 3: // Employee
                $modulePermissions[] = 'task_management';
                break;
        }
        $this->module_permissions = $modulePermissions;
    }

    public function compose(View $view): void
    {
        $data = [
            'permissions' => $this->permissions,
            'module_permissions' => $this->module_permissions,
        ];

        $view->with($data);
    }
}
