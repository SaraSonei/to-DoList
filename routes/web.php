<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/register', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])
        ->middleware('permission:task.view')
        ->name('tasks.index');

    Route::get('/tasks/create', [TaskController::class, 'create'])
        ->middleware('permission:task.create')
        ->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
        ->middleware('permission:task.create')
        ->name('tasks.store');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->middleware(['permission:task.edit', 'can:update,task'])
        ->name('tasks.edit');

    Route::patch('/tasks/{task}', [TaskController::class, 'update'])
        ->middleware(['permission:task.edit', 'can:update,task'])
        ->name('tasks.update');

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
        ->middleware(['permission:task.delete', 'can:delete,task'])
        ->name('tasks.destroy');

    Route::get('/adminList', [UserController::class, 'showAdmins'])
        ->middleware('permission:view.admins')
        ->name('admin.list');

    Route::get('/usersList', [UserController::class, 'showAllUsers'])
        ->middleware('permission:view.all.users')
        ->name('users.list');
});

