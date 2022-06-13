<?php

use App\Http\Controllers\AlbaranController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

#region Login
Route::post('login', [AuthController::class, 'login']);
Route::post('regSign', [UserController::class, 'regSign']);
Route::put('updatePassword', [UserController::class, 'updatePassword'])->middleware('auth:sanctum');
#endregion

#region User
Route::get('actualUser', [UserController::class, 'getAutenticatedUser'])->middleware('auth:sanctum');
Route::get('users', [UserController::class, 'getUsers'])->middleware('auth:sanctum');
Route::post('regUser', [UserController::class, 'regUser'])->middleware('auth:sanctum');
Route::put('updateUser', [UserController::class, 'updateUser'])->middleware('auth:sanctum');
Route::put('deleteUser', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');
Route::put('resetPassword', [UserController::class, 'resetPassword'])->middleware('auth:sanctum');
#endregion

#region Obras
Route::get('obras', [ObraController::class, 'getObras'])->middleware('auth:sanctum');
Route::post('regObra', [ObraController::class, 'regObra'])->middleware('auth:sanctum');
Route::put('updateObra', [ObraController::class, 'updateObra'])->middleware('auth:sanctum');
Route::delete('deleteObra/{obra_id}', [ObraController::class, 'deleteObra'])->middleware('auth:sanctum');
#endregion

#region Servicios
Route::get('serviciosUser', [ServicioController::class, 'getDetailedServices'])->middleware('auth:sanctum');
Route::get('specificServicio/{servicio_id}', [ServicioController::class, 'getSpecificServicio'])->middleware('auth:sanctum');
Route::post('finalizarServicio', [ServicioController::class, 'finalizarServicio'])->middleware('auth:sanctum');

Route::get('servicios', [ServicioController::class, 'getServicios'])->middleware('auth:sanctum');
Route::post('regServicio', [ServicioController::class, 'regServicio'])->middleware('auth:sanctum');
Route::put('updateServicio', [ServicioController::class, 'updateServicio'])->middleware('auth:sanctum');
Route::delete('deleteServicio/{servicio_id}', [ServicioController::class, 'deleteServicio'])->middleware('auth:sanctum');
#endregion

#region Clientes
Route::get('clientes', [ClienteController::class, 'getClientes'])->middleware('auth:sanctum');
Route::post('regCliente', [ClienteController::class, 'regCliente'])->middleware('auth:sanctum');
Route::put('updateCliente', [ClienteController::class, 'updateCliente'])->middleware('auth:sanctum');
Route::put('deleteCliente', [ClienteController::class, 'deleteCliente'])->middleware('auth:sanctum');
#endregion

#region Maquinas
Route::get('maquinas', [MaquinaController::class, 'getMaquinas'])->middleware('auth:sanctum');
Route::post('regMaquina', [MaquinaController::class, 'regMaquina'])->middleware('auth:sanctum');
Route::put('updateMaquina', [MaquinaController::class, 'updateMaquina'])->middleware('auth:sanctum');
Route::put('deleteMaquina', [MaquinaController::class, 'deleteMaquina'])->middleware('auth:sanctum');
#endregion

#region PDF
Route::get('downloadPDF/{servicio_id}', [AlbaranController::class, 'downloadPDF'])->middleware('auth:sanctum');
Route::get('sendPDF/{servicio_id}', [AlbaranController::class, 'sendPDF'])->middleware('auth:sanctum');
#endregion