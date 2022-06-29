<?php

namespace App\Libs\Actions;

use App\Http\Resources\ReferResource;
use App\Libs\Helpers\SystemHelper;
use App\Models\Refer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Refer Action
 */
class ReferAction
{
    /**
     * @var Refer
     */
    private Refer $model;
    /**
     * @var SystemHelper
     */
    private SystemHelper $helper;

    /**
     * @param Refer $model
     * @param SystemHelper $helper
     */
    public function __construct(Refer $model, SystemHelper $helper)
    {
        $this->model = $model;
        $this->helper = $helper;
    }

    /**
     * crete refer
     * @param $request
     * @return JsonResponse
     */
    public function createReferAction($request): JsonResponse
    {
        try {
            $appointment = $this->model->create([
                'enrolle_id' => $this->helper->getEnrolleeId($request->emp_code),
                'health_care_id' => auth()->user()->hospital->id,
                'case' => $request->case,
                'hospital_name' => $request->hospital_name,
                'remark' => $request->remark
            ]);
            return response()->json([
                'message' => 'Referral made successfully',
                'data' => new ReferResource($appointment),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to make referral',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get all refers
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllReferAction(): JsonResponse|AnonymousResourceCollection
    {
        if (auth()->user()->role == 'superadmin'){
            $referrals = $this->model->with(['enrolle', 'hospital'])->latest()->paginate(10);
        } else {
            $referrals= $this->model->where('health_care_id', '=', auth()->user()->hospital->id)->with(['enrolle'])->latest()->paginate(10);
        }
        if (count($referrals) < 1) {
            return response()->json([
                'message' => 'Sorry no referral found',
                'success' => false
            ], 404);
        }else {
            return ReferResource::collection($referrals)->additional([
                'message' => "Referral fetched successfully",
                'success' => true
            ], 200);
        }
    }

    /**
     * get single refer
     * @param $id
     * @return ReferResource
     */
    public function getSingleReferAction($id): ReferResource
    {
        $refer = $this->model->findOrFail($id);
        return (new ReferResource($refer))->additional( [
            'message' => "Referral details",
            'success' => true
        ], 200);
    }

}
