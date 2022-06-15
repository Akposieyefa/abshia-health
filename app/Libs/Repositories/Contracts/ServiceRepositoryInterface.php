<?php

namespace App\Libs\Repositories\Contracts;

interface ServiceRepositoryInterface
{
    public function createService($request);
    public function getSingleService($id);
    public function getAllService();
    public function updateService($request, $id);
    public function deleteService($id);
}

