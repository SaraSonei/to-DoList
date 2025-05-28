<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});


//Route::resource('/admin/task', TaskController::class);



Route::get('/register', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);


Route::prefix('admin')->controller(TaskController::class)->group(function () {
    Route::get('/tasks', 'index')->name('tasks.index');
    Route::get('/tasks/create', 'create');
    Route::post('/tasks', 'store')->name('tasks.store');

    Route::get('/tasks/{task}/edit', 'edit')
        ->middleware('can:update,task');

    Route::patch('/tasks/{task}', 'update')->name('tasks.update')
        ->middleware('can:update,task');

    Route::delete('/tasks/{task}', 'destroy')
        ->middleware('can:delete,task');
});


