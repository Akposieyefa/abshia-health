<?php

namespace App\Libs\Repositories\Contracts;

interface ClaimRepositoryInterface
{
    public function createClaim($request);
    public function getSingleClaim($id);
    public function getAllClaim();
    public function updateClaim($request, $id);
    public function deleteClaim($id);
    public function approveClaim($id);
    public function declineClaim($id);
}
