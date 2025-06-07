<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'store']);

Route::middleware('prevent_admin_login_user')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});


Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('/tasks', [TaskController::class, 'index'])
        ->name('tasks.index');

    Route::get('/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->middleware(['can:update,task'])
        ->name('tasks.edit');

    Route::patch('/tasks/{task}', [TaskController::class, 'update'])
        ->middleware(['can:update,task'])
        ->name('tasks.update');

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
       // ->middleware(['can:delete,task'])
        ->name('tasks.destroy');
});

Route::middleware('prevent_user_login_admin')->group(function () {
    Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
});
Route::prefix('admin')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/ViewAdmins', [AdminController::class, 'showAdmins'])->middleware('permission:view.admins')->name('admins.list');
        Route::get('/ViewUsers', [AdminController::class, 'showAllUsers'])->middleware('permission:view.all.users')->name('users.list');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });

});

