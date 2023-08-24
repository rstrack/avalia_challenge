<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/vehicles', [VehicleController::class, 'listVehicles']);
Route::get('/vehicle/{id}', [VehicleController::class, 'getVehicle']);
Route::post('/vehicle/new', [VehicleController::class, 'createVehicle']);
Route::put('/vehicle/{id}', [VehicleController::class, 'updateVehicle']);
Route::delete('/vehicle/{id}', [VehicleController::class, 'deleteVehicle']);
