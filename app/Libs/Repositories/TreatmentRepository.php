<?php

namespace App\Libs\Repositories;

use App\Http\Resources\TreatmentResource;
use App\Libs\Repositories\Contracts\TreatmentRepositoryInterface;
use App\Libs\Actions\TreatmentAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 * Treatment
 */
class TreatmentRepository implements TreatmentRepositoryInterface
{
    /**
     * @var TreatmentAction
     */
    private TreatmentAction $action;

    /**
     * @param TreatmentAction $action
     */
    public function __construct(TreatmentAction $action)
    {
        $this->action = $action;
    }

    /**
     * create treatment
     * @param $request
     * @return JsonResponse
     */
    public function createTreatment($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'emp_code' => 'required',
            'verified_by' => 'required',
            'date_and_time' => 'required',
            'is_capitated' => 'required',
            'is_ffs' => 'required',
            'drugs' => 'required',
            'cost_of_treatment' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'blood_pressure' => 'required',
            'pulse' => 'required',
            'respiration' => 'required',
            'temperature' => 'required',
            'treatment_give' => 'required',
            'is_referred' => 'required',
            'summary' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return  $this->action->createTreatmentAction($request);
        }
    }

    /**
     * get all treatment
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllTreatments(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllTreatmentsAction();
    }

    /**
     * get single treatment
     * @param $id
     * @return TreatmentResource
     */
    public function getSingleTreatment($id): TreatmentResource
    {
        return $this->action->getSingleTreatmentAction($id);
    }

     /**
     * get single treatment
     * @param $id
     * @return TreatmentResource
     */
    public function getTreatmentByEnrolleID($id) : TreatmentResource 
    {
        return $this->action->getTreatmentByEnrolleID($id);
    }

    /**
     * delete treatment
     * @param $id
     * @return JsonResponse
     */
    public function deleteTreatment($id): JsonResponse
    {
        return $this->action->deleteTreatmentAction($id);
    }

}
