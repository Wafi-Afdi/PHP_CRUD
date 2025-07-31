<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Login & Registration
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, 'login']);

Route::redirect('/laravel/login', '/login')->name('login');


// Protected resource
Route::group([
    "middleware" => ["auth:api"]
], function() {
    Route::post("task", [TaskController::class, 'store']);
    Route::get("task", [TaskController::class, 'list']);
    Route::put("task/{task}", [TaskController::class, 'update']);
    Route::delete("task/{task}", [TaskController::class, 'destroy']);
});
