<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'],function (){

    Route::get('/projects', 'App\Http\Controllers\Project\IndexController');
    Route::patch('/project/{project}', 'App\Http\Controllers\Project\UpdateController');
    Route::post('/projects', 'App\Http\Controllers\Project\StoreController');

    Route::patch('/projects/tasks/{id}/start','App\Http\Controllers\Task\UpdateStartController');
    Route::post('/projects/{id}/tasks', 'App\Http\Controllers\Task\StoreController');
    Route::patch('/projects/tasks/{id}/stop', 'App\Http\Controllers\Task\UpdateTotalTimeController');
});
