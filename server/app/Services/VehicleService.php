<?php
namespace App\Services;

use App\Exceptions\AppError;
use App\Http\Resources\VehicleResource;
use App\Repositories\VehicleRepositoryInterface;

class VehicleService {

    public function __construct(protected VehicleRepositoryInterface $repository){}

    public function save($data, $id = null) {
        
        if ((int)$data['year'] < 1950 || (int)$data['year'] >  date("Y") + 1){
            throw new AppError('Ano inválido');
        }


        if($id != null){
            $vehicle = $this->repository->update($data, $id);
        } else {
            $vehicle = $this->repository->create($data);
        }

        return new VehicleResource($vehicle);
    }

    public function list(){
        $vehicles = $this->repository->findAll();
        return VehicleResource::collection($vehicles);      
    }
}