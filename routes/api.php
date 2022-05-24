<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

#region Login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
#endregion

#region User
Route::get('actualUser', [UserController::class, 'getAutenticatedUser'])->middleware('auth:sanctum');
Route::get('allUsers', [UserController::class, 'getUsers'])->middleware('auth:sanctum');
Route::post('regUser', [UserController::class, 'regUser'])->middleware('auth:sanctum');
Route::put('updateUser', [UserController::class, 'updateUser'])->middleware('auth:sanctum');
Route::delete('deleteUser/{user_id}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');
Route::put('resetPassword', [UserController::class, 'resetPassword'])->middleware('auth:sanctum');
#endregion

#region Obras
Route::get('/obras', [ObraController::class, 'getAll'])->middleware('auth:sanctum');
Route::get('/obras/{id}', [ObraController::class, 'getSpecific']);
#endregion

#region Servicios
Route::get('serviciosUser', [ServicioController::class, 'getDetailedServices'])->middleware('auth:sanctum');
#endregion

#region Clientes
Route::get('clientes', [ClienteController::class, 'getClientes'])->middleware('auth:sanctum');
Route::post('regCliente', [ClienteController::class, 'regCliente'])->middleware('auth:sanctum');
Route::put('updateCliente', [ClienteController::class, 'updateCliente'])->middleware('auth:sanctum');
Route::delete('deleteCliente/{cliente_id}', [ClienteController::class, 'deleteCliente'])->middleware('auth:sanctum');
#endregion