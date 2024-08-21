<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("login", [LoginController::class,"login"]);
Route::post("register", [RegisterController::class,"register"]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post("logout", [LogoutController::class,"logout"]);
    Route::get("profile", [UserController::class,"getProfile"]);
    Route::put("profile/{id}", [UserController::class,"updateProfile"]);
    Route::delete("profile/{id}", [UserController::class,"destroyProfile"]);

    Route::get("project", [ProjectController::class,"getProject"]);
    Route::post("project", [ProjectController::class,"createProject"]);
    Route::put("project/{id}", [ProjectController::class,"updateProject"]);
    Route::delete("project/{id}", [ProjectController::class,"destroyProject"]);
    
    
    Route::get("task", [TaskController::class,"getTask"]);
    Route::post("task", [TaskController::class,"createTask"]);
    Route::put("task/{id}", [TaskController::class,"updateTask"]);
    Route::delete("task/{id}", [TaskController::class,"destroyTask"]);
});


