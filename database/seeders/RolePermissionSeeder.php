<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\EnumRoleName;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminRole = Role::create(['name' => enumRoleName::ADMIN->value]);
        $userRole  = Role::create(['name'  => EnumRoleName::USER->value]);

        $permViewAdmins   = Permission::create([
            'name'        => 'view.admins',
        ]);
        $permViewAllUsers = Permission::create([
            'name'        => 'view.all.users',
        ]);
        $permTask = [
            'task.view',
            'task.create',
            'task.edit',
            'task.delete',

        ];

        foreach ($permTask as $perm) {
            Permission::create(['name' => $perm]);
        }


        $admin1 = User::create([
            'firstName'     => 'Admin One',
            'lastName' => 'LastName',
            'email'    => 'admin1@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin1->roles()->attach($adminRole->id);
        $admin1->permissions()->attach($permViewAdmins->id);

        $admin2 = User::create([
            'firstName'     => 'Admin Two',
            'lastName' => 'LastName',
            'email'    => 'admin2@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin2->roles()->attach($adminRole->id);
        $admin2->permissions()->attach([$permViewAdmins , $permViewAllUsers]);

        $regularUser = User::create([
            'firstName'     => 'Regular User',
            'lastName' => 'LastName',
            'email'    => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
        $regularUser->roles()->attach($userRole->id);
        $regularUser->permissions()->sync(Permission::whereIn('name', ['task.view' , 'task.create' , 'task.edit' , 'task.delete'])->pluck('id'));



    }
}
