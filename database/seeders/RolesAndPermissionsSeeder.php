<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            
            Schema::disableForeignKeyConstraints();
            Role::truncate();
            Permission::truncate();
            User::truncate();
            Schema::enableForeignKeyConstraints();
    
            // Define permissions
            $permissions = [
                'create-task',
                'read-task',
                'update-task',
                'delete-task',
                'create-user',
                'read-user',
                'update-user',
                'delete-user',
            ];
    
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
    
            // Create roles and assign permissions
            $roles = [
                'admin' => ['create-task', 'read-task', 'update-task', 'delete-task','create-user','read-user','update-user','delete-user'],
                'manager' => ['create-task', 'read-task', 'update-task','delete-task'],
                'employee' => ['read-task', 'update-task'],
            ];
    
            foreach ($roles as $roleName => $rolePermissions) {
                $role = Role::create(['name' => $roleName]);
                $role->givePermissionTo($rolePermissions);
            }
    
            // Create admin user
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('Admin@123'),
            ]);
            $admin->assignRole('admin');
            $admin->update(['role_id' => $admin->roles->first()->id]);
    
            // Create manager user
            $manager = User::create([
                'name' => 'Test Manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('Manager@123'),
            ]);
            $manager->assignRole('manager');
            $manager->update(['role_id' => $manager->roles->first()->id]);
    
            // Create employee user
            $employee = User::create([
                'name' => 'Test Employee',
                'email' => 'employee@employee.com',
                'password' => Hash::make('Employee@123'),
            ]);
            $employee->assignRole('employee');
            $employee->update(['role_id' => $employee->roles->first()->id]);
        }
    }
}
