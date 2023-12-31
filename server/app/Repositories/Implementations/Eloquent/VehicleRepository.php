<?php
namespace App\Repositories\Implementations\Eloquent;
use App\Repositories\VehicleRepositoryInterface;
use App\Models\Vehicle;

class VehicleRepository implements VehicleRepositoryInterface {
    public function delete($id){
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
    }

    public function findByID($id){
        $vehicle = Vehicle::findOrFail($id);
        return $vehicle;
    }

    public function findAll($pageSize, $filter){
        return Vehicle::where('name', 'like', '%'. $filter . '%')
        ->orWhere('brand', 'like', '%'. $filter . '%')
        ->orWhere('year', 'like', '%'. $filter . '%')
        ->orWhere('plate', 'like', '%'. $filter . '%')
        ->paginate($pageSize);
    }

    public function create($data){
        return Vehicle::create($data);
    }

    public function update($data, $id){
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($data);
        return $vehicle;
    }
}