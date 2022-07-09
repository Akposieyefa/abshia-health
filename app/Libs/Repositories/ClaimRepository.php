<?php

namespace App\Libs\Repositories;

use App\Http\Resources\ClaimResource;
use App\Libs\Repositories\Contracts\ClaimRepositoryInterface;
use App\Libs\Actions\ClaimAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 * Claim repository
 */
class ClaimRepository implements ClaimRepositoryInterface
{
    /**
     * @var ClaimAction
     */
    private ClaimAction $action;

    /**
     * @param ClaimAction $action
     */
    public function __construct(ClaimAction $action)
    {
        $this->action = $action;
    }

    /**
     * create claim
     * @param $request
     * @return JsonResponse
     */
    public function createClaim($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'emp_code' => 'required',
            'date_of_admission' => 'required',
            'date_of_discharge' => 'required',
            'treatment_details'=> 'required',
            'diagnosis'=> 'required',
            'investigations'=> 'required',
            'cost'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createClaimAction($request);
        }
    }

    /**
     * get single ckaim
     * @param $id
     * @return ClaimResource
     */
    public function getSingleClaim($id): ClaimResource
    {
        return $this->action->getSingleClaimAction($id);
    }

    /**
     * get all claim
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllClaim(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllClaimAction();
    }

    /**
     * update claim
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateClaim($request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date_of_admission' => 'sometimes',
            'date_of_discharge' => 'sometimes',
            'treatment_details'=> 'sometimes',
            'diagnosis'=> 'sometimes',
            'investigations'=> 'sometimes',
            'cost'=> 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->updateClaimAction($request, $id);
        }
    }

    public function approveClaim($id)
    {
        return $this->action->approveClaimAction($id);
    }

    public function declineClaim($id)
    {
        return $this->action->declineClaimAction($id);
    }

    /**
     * delete claim
     * @param $id
     * @return JsonResponse
     */
    public function deleteClaim($id): JsonResponse
    {
        return $this->action->deleteClaimAction($id);
    }

}
