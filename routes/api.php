<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TaskController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/getTasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
});
//Route::prefix('auth')->group(function () {
//   // Route::post('/register', [AuthController::class, 'register']);
//    //Route::post('/login', [AuthController::class, 'login']);
//    Route::post('/login', [LoginController::class, 'login'])->name('login');
//    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
//});
