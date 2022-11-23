<?php

use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function (){
    Route::apiResource('users',UserController::class);
    Route::middleware('auth:api')->group(function () {
        Route::apiResource('tasks',TaskController::class);
        Route::post('tasks/{id}/change-status',[TaskController::class,'changeStatus']);
    });

});
