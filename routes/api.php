<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ObraController;
use Illuminate\Support\Facades\Route;

#region Users
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('actualUser', [AuthController::class, 'getAutenticatedUser'])->middleware('auth:sanctum');
#endregion

#region Obras
Route::get('/obras', [ObraController::class, 'getAll'])->middleware('auth:sanctum');
Route::get('/obras/{id}', [ObraController::class, 'getSpecific']);
#endregion