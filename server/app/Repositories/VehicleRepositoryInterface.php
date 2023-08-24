<?php
namespace App\Repositories;

interface VehicleRepositoryInterface {
    public function delete($id);
    public function findByID($id);
    public function findAll();
    public function create($data);
    public function update($data, $id);

}