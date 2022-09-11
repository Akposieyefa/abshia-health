<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\PlanRepositoryInterface;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * @var PlanRepositoryInterface
     */
    private  PlanRepositoryInterface $planRepositoryInterface;

    /**
     * @param PlanRepositoryInterface $planRepositoryInterface
     */
    public function __construct(PlanRepositoryInterface $planRepositoryInterface)
    {
        $this->planRepositoryInterface = $planRepositoryInterface;
    }

    /**
     * get all plans
     * @return mixed
     */
    public function index(): mixed
    {
        return  $this->planRepositoryInterface->getAllPlans();
    }

    /**
     * create plan
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->planRepositoryInterface->createPlan($request);
    }

    /**
     * show single plan
     * @param int $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        return  $this->planRepositoryInterface->showSinglePlan($id);
    }

    /**
     * update plan
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id): mixed
    {
        return $this->planRepositoryInterface->updatePlan($request, $id);
    }

    /**
     * delete plan
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return $this->planRepositoryInterface->deletePlan($id);
    }

}
