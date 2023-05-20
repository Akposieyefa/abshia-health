<?php

namespace App\Libs\Actions;

use App\Models\Claim;
use Illuminate\Http\JsonResponse;
use App\Libs\Helpers\SystemHelper;
use App\Http\Resources\ClaimResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Claim Action
 */
class ClaimAction
{
    /**
     * @var Claim
     */
    private Claim $model;
    /**
     * @var SystemHelper
     */
    private SystemHelper $helper;

    /**
     * @param Claim $model
     * @param SystemHelper $helper
     */
    public function __construct(Claim $model, SystemHelper $helper)
    {
        $this->model = $model;
        $this->helper = $helper;
    }

    /**
     * create claim
     * @param $request
     * @return JsonResponse
     */
    public function createClaimAction($request): JsonResponse
    {
        try {
            $claim = $this->model->create([
                'enrolle_id' => $this->helper->getEnrolleeId($request->emp_code),
                'health_care_id' => auth()->user()->hospital->id,
                'date_of_admission' => $request->date_of_admission, 
                'date_of_discharge' => $request->date_of_discharge,
                'treatment_details' => $request->treatment_details, 
                'diagnosis' => $request->diagnosis, 
                'investigations' => $request->investigations, 
                'cost' => $request->cost
            ]);
            return response()->json([
                'message' => 'Claim request created successfully',
                'data' => new ClaimResource($claim),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to create claim request',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get single claim
     * @param $id
     * @return ClaimResource
     */
    public function getSingleClaimAction($id): ClaimResource
    {
        $claim = $this->model->with(['enrolle', 'hospital'])->findOrFail($id);
        return (new ClaimResource($claim))->additional( [
            'message' => "Claim details",
            'success' => true
        ], 200);
    }

    public function approveClaimAction($id)
    {
        $claim = $this->model->findOrFail($id);
        try {
            $claim->update([
                'payment_status' => 'approved'
            ]);
            return response()->json([
                'message' => 'Claim request approved successfully',
                'data' => new ClaimResource($claim),
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable approve claim request',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }
    
    public function declineClaimAction($id)
    {
        $claim = $this->model->findOrFail($id);
        try {
            $claim->update([
                'payment_status' => 'declined'
            ]);
            return response()->json([
                'message' => 'Claim request declined  successfully',
                'data' => new ClaimResource($claim),
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable approve declined request',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }


    /**
     * get all claim
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllClaimAction(): JsonResponse|AnonymousResourceCollection
    {
        $claims = $this->model->with(['enrolle', 'hospital'])->latest()->paginate(10);
        return ClaimResource::collection($claims)->additional([
            'message' => "All claims",
            'success' => true
        ], 200);
    }

    /**
     * update claim
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateClaimAction($request, $id): JsonResponse
    {
        $claim =  $this->model->findOrFail($id);
        try {
            $update = $claim->update([
                'date_of_admission' => empty($request->date_of_admission) ? $claim->date_of_admission :  $request->date_of_admission, 
                'date_of_discharge' => empty($request->date_of_discharge) ? $claim->date_of_discharge : $request->date_of_discharge,
                'treatment_details' => empty($request->treatment_details) ? $claim->treatment_details : $request->treatment_details, 
                'diagnosis' => empty($request->diagnosis) ? $claim->diagnosis :  $request->diagnosis, 
                'investigations' => empty($request->investigations) ? $claim->investigations : $request->investigations, 
                'cost' => empty($request->cost) ? $claim->cost : $request->cost
            ]);
            return response()->json([
                'message' => 'Claim edited successfully',
                'data' => new ClaimResource($claim),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to edit claim',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * delete claim
     * @param $id
     * @return JsonResponse
     */
    public function deleteClaimAction($id): JsonResponse
    {
        $claim =  $this->model->findOrFail($id);
        try {
            $claim->delete();
            return response()->json([
                'message' => 'Claim deleted successfully',
                'data' => new ClaimResource($claim),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete claim',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
