<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TaskController;


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/getTasks', [TaskController::class, 'index'])
        ->middleware('permission:task.view');
    Route::post('/tasks', [TaskController::class, 'store'])
        ->middleware('permission:task.create');
});
