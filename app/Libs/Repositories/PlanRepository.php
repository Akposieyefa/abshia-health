<?php

namespace App\Libs\Repositories;

use App\Http\Resources\PlanResource;
use App\Libs\Actions\PlanAction;
use App\Libs\Repositories\Contracts\PlanRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 * Plan repository
 */
class PlanRepository implements  PlanRepositoryInterface
{
    /**
     * @var PlanAction
     */
    private PlanAction $action;

    /**
     * @param PlanAction $action
     */
    public function __construct(PlanAction $action)
    {
        $this->action = $action;
    }

    /**
     * create plan
     * @param $request
     * @return JsonResponse
     */
    public function createPlan($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'cost' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return  $this->action->createPlanAction($request);
        }
    }

    /**
     * get all plans
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllPlans(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllPlanAction();
    }


    /**
     * show single plan
     * @param $id
     * @return PlanResource
     */
    public function showSinglePlan($id): PlanResource
    {
        return $this->action->getSinglePlanAction($id);
    }

    /**
     * update plan
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updatePlan($request, $id): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'title' => 'sometimes',
            'description' => 'sometimes',
            'duration' => 'sometimes',
            'cost' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return  $this->action->updatePlanAction($request, $id);
        }
    }

    /**
     * delete plan
     * @param $id
     * @return JsonResponse
     */
    public function deletePlan($id): JsonResponse
    {
        return $this->action->deletePlanAction($id);
    }

}
