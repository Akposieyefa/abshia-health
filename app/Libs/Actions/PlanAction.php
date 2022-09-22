<?php

namespace App\Libs\Actions;
use App\Http\Resources\PlanResource;
use App\Libs\Helpers\SystemHelper;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Plan action
 */
class PlanAction
{
    /**
     * @var Plan
     */
    private Plan $model;
    /**
     * @var SystemHelper
     */
    private SystemHelper $systemHelper;

    /**
     * @param Plan $model
     * @param SystemHelper $systemHelper
     */
    public function __construct(Plan $model, SystemHelper $systemHelper)
    {
        $this->model = $model;
        $this->systemHelper = $systemHelper;
    }

    /**
     * create plan action
     * @param $request
     * @return JsonResponse
     */
    public function createPlanAction($request): JsonResponse
    {
        try {
            $plan = $this->model->create([
                'title' => $request->title,
                'description' => $request->description,
                'duration' => $request->duration,
                'cost' => $this->systemHelper->convertToKobo($request->cost),
            ]);
            return response()->json([
                'message' => 'Plan created successfully',
                'data' => new PlanResource($plan),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to create plan',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get all plan
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllPlanAction(): JsonResponse|AnonymousResourceCollection
    {
        $plans = $this->model->latest()->paginate(10);
        if (count($plans) < 1) {
            return response()->json([
                'message' => 'Sorry no plan found',
                'success' => false
            ], 404);
        }else {
            return PlanResource::collection($plans)->additional([
                'message' => "All plans",
                'success' => true
            ], 200);
        }
    }

    /**
     * get single plan
     * @param $id
     * @return PlanResource
     */
    public function getSinglePlanAction($id): PlanResource
    {
        $plan = $this->model->findOrFail($id);
        return (new PlanResource($plan))->additional( [
            'message' => "Plans details",
            'success' => true
        ], 200);
    }

    /**
     * update plan
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updatePlanAction($request, $id): JsonResponse
    {
        $plan = $this->model->findOrFail($id);
        $plan->slug = null;
        try {
            $plan->update([
                'title' => empty($request->title) ? $plan->title : $request->title,
                'description' =>   empty($request->description) ? $plan->description : $request->description,
                'duration' =>  empty($request->duration) ? $plan->duration : $request->duration,
                'cost' =>  empty($request->cost) ? $plan->cost : $this->systemHelper->convertToKobo($request->cost)
            ]);
            return response()->json([
                'message' => 'Plan updated successfully',
                'data' => new PlanResource($plan),
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to update plan',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * delete plan
     * @param $id
     * @return JsonResponse
     */
    public function deletePlanAction($id): JsonResponse
    {
        $plan =  $this->model->findOrFail($id);
        try {
            $plan->delete();
            return response()->json([
                'message' => 'Plan deleted successfully',
                'data' => new PlanResource($plan),
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete plan',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
