<?php

namespace App\Libs\Repositories\Contracts;

interface PlanRepositoryInterface
{
    public function createPlan($request);
    public function getAllPlans();
    public function showSinglePlan($id);
    public function updatePlan($request, $id);
    public function deletePlan($id);
}
