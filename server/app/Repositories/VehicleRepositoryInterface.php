<?php
namespace App\Repositories;

interface VehicleRepositoryInterface {
    public function delete($id);
    public function findByID($id);
    public function findAll($pageSize, $filter);
    public function create($data);
    public function update($data, $id);

}