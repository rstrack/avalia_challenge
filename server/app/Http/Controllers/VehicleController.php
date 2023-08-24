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

    public function updateVehicle(SaveVehicleRequest $request, string $id){
        $data = $request->validated();
        return $this->service->save($data, $id);
    }

    public function deleteVehicle(string $id){
        $this->service->delete($id);
        return response()->json([], 204);
    }

    public function getVehicle(string $id){
        return $this->service->get($id);
    }
}
