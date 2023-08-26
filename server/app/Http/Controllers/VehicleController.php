<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveVehicleRequest;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    public function __construct(protected VehicleService $service){}
    
    public function listVehicles(Request $request){
        $pageSize = $request->query('size');
        $filter = $request->query('filter');
        return $this->service->list($pageSize, $filter);
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
