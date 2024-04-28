<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/user/{id}',[\App\Http\Controllers\Api\v1\UserController::class, 'show']);
Route::get('/users',[\App\Http\Controllers\Api\v1\UserController::class, 'index']);
Route::delete('/user/{id}',[\App\Http\Controllers\Api\v1\UserController::class, 'del']);
Route::put('/user/{id}',[\App\Http\Controllers\Api\v1\UserController::class, 'update']);
