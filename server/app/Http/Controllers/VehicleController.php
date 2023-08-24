<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveVehicleRequest;
use App\Services\VehicleService;

class VehicleController extends Controller
{

    public function __construct(protected VehicleService $service){}

    public function listVehicles(){
        return $this->service->list();
    }

    public function createVehicle(SaveVehicleRequest $request){
        $data = $request->validated();
        return $this->service->save($data);
    }
}
