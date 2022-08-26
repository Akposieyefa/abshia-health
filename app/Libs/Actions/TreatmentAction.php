<?php

namespace App\Libs\Actions;

use App\Http\Resources\TreatmentResource;
use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Libs\Helpers\SystemHelper;

/**
 *
 */
class TreatmentAction
{
    /**
     * @var Treatment
     */
    private Treatment $model;
    /**
     * @var SystemHelper
     */
    private SystemHelper $helper;

    /**
     * @param Treatment $model
     * @param SystemHelper $helper
     */
    public function __construct(Treatment $model, SystemHelper $helper)
    {
        $this->model = $model;
        $this->helper = $helper;
    }

    /**
     * create treatment
     * @param $request
     * @return JsonResponse
     */
    public function createTreatmentAction($request): JsonResponse
    {
        try {
            $treatment = $this->model->create([
                'enrolle_id' => $this->helper->getEnrolleeId($request->emp_code),
                'health_care_id' => auth()->user()->hospital->id,
                'verified_by' => $request->verified_by,
                'date_and_time' => $request->date_and_time,
                'is_capitated' => filter_var($request->is_capitated, FILTER_VALIDATE_BOOLEAN),
                'is_ffs' =>  filter_var($request->is_ffs, FILTER_VALIDATE_BOOLEAN),
                'drugs' => $request->drugs,
                'cost_of_treatment' => $request->cost_of_treatment,
                'height' => $request->height,
                'weight' => $request->weight,
                'blood_pressure' => $request->blood_pressure,
                'pulse' => $request->pulse,
                'respiration' => $request->respiration,
                'temperature' => $request->temperature,
                'treatment_give' => $request->treatment_give,
                'is_referred' => filter_var( $request->is_referred, FILTER_VALIDATE_BOOLEAN),
                'summary' => $request->summary
            ]);
            return response()->json([
                'message' => 'Treatment given successfully',
                'data' => new TreatmentResource($treatment),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to give treatment',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get all treatment
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllTreatmentsAction(): JsonResponse|AnonymousResourceCollection
    {
        if (auth()->user()->role == 'superadmin'){
            $treatments = $this->model->with(['enrolle', 'hospital'])->latest()->paginate(10);
        } elseif(auth()->user()->role == 'hospital') {
            $treatments = $this->model->where('health_care_id', '=', auth()->user()->hospital->id)->with(['enrolle', 'hospital'])->latest()->paginate(10);
        } else {
            $treatments = $this->model->where('enrolle_id', '=', auth()->user()->enrollee->id)->latest()->paginate(10);
        }

        if (count($treatments) < 1) {
            return response()->json([
                'message' => 'Sorry no treatment found',
                'success' => false
            ], 404);
        }else {
            return TreatmentResource::collection($treatments)->additional([
                'message' => "Treatments fetched successfully",
                'success' => true
            ], 200);
        }
    }

    /**
     * get single treatment
     * @param $id
     * @return TreatmentResource
     */
    public function getSingleTreatmentAction($id): TreatmentResource
    {
        $treatment = $this->model->findOrFail($id);
        return (new TreatmentResource($treatment))->additional( [
            'message' => "Treatment details",
            'success' => true
        ], 200);
    }

     /**
     * get treatement treatment
     * @param $id
     * @return TreatmentResource
     */
    public function getTreatmentByEnrolleIDAction($id): TreatmentResource
    {
        $treatment = $this->model->where('enrolle_id', '=', $id)->latest()->paginate(10);
        return (new TreatmentResource($treatment))->additional( [
            'message' => "Treatment details",
            'success' => true
        ], 200);
    }

    /**
     * delete treatment
     * @param $id
     * @return JsonResponse
     */
    public function deleteTreatmentAction($id): JsonResponse
    {
        $treatment =  $this->model->findOrFail($id);
        try {
            $treatment->delete();
            return response()->json([
                'message' => 'Treatment deleted successfully',
                'data' => new TreatmentResource($treatment),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete delete',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
