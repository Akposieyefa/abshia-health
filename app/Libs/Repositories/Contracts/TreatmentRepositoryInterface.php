<?php

namespace App\Libs\Repositories\Contracts;

interface TreatmentRepositoryInterface
{
    public function createTreatment($request);
    public function getAllTreatments();
    public function getSingleTreatment($id);
    public function deleteTreatment($id);
    public function getTreatmentByEnrolleID($id);
}
