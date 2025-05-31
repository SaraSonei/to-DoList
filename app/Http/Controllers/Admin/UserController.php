<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\EnumRoleName;
use App\Http\Middleware\PermissionMiddleware;


class UserController extends Controller
{
//    public static function middleware(): array
//    {
//        return [
//            new Middleware('auth'),
//            new Middleware('permission:view.admins', only: ['showAdmins']),
//            new Middleware('permission:view.all.users', only: ['showAllUsers']),
//        ];
//    }

    public function showAdmins()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })
        ->get();

        return view('admin.users.index', compact('users'));
    }

    public function showAllUsers()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
            ->get();
        return view('admin.users.index', compact('users'));

    }

    public function showUserCreateTask(){
        $users = User::whereHas('permission', function ($query) {
            $query->where('name', 'task.create');
        })->get();
        return view('admin.users.index', compact('users'));
    }
}
