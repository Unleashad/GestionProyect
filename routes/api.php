<?php

use App\Http\Controllers\ObraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region Obras
Route::get('/obras', [ObraController::class, 'getAll']);
Route::get('/obras/{id}', [ObraController::class, 'getSpecific']);
#endregion