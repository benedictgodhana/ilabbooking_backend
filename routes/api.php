<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and are assigned to the
| "api" middleware group. Now create something great!
|
*/

// Authentication routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('/getRooms', [RoomController::class, 'index']);
Route::get('/getUser', [UserController::class, 'getUser']);
Route::get('/getRoles', [RoleController::class, 'getRoles']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);


Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user/permissions', [UserController::class, 'permissions']);


// Protected route - requires authentication
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
