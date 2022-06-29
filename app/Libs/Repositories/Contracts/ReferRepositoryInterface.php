<?php

namespace App\Libs\Repositories\Contracts;

interface ReferRepositoryInterface
{
    public function createRefer($request);
    public function getAllRefer();
    public function getSingleRefer($id);
}
