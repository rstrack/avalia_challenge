<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/vehicles', [VehicleController::class, 'listVehicles']);
Route::post('/vehicles', [VehicleController::class, 'createVehicle']);
