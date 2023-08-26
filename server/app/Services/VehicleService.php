<?php
namespace App\Services;

use App\Exceptions\AppError;
use App\Http\Resources\VehicleResource;
use App\Repositories\VehicleRepositoryInterface;

const DEFAULT_PAGINATION_SIZE = 10;

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

    public function list($pageSize, $filter){
        if(!$pageSize || $pageSize < 1){
            $_pageSize = DEFAULT_PAGINATION_SIZE;
        }else $_pageSize = $pageSize;

        $vehicles = $this->repository->findAll($_pageSize, $filter);
        return VehicleResource::collection($vehicles);      
    }

    public function get($id){
        $vehicle = $this->repository->findByID($id);
        return new VehicleResource($vehicle);      
    }

    public function delete($id){
        $this->repository->delete($id);    
    }
}