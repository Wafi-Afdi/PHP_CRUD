<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Login & Registration
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, 'login']);


// Protected resource
// Route::group([
//     "middleware" => ["auth:api"]
// ], function() {
//     ;
// });
