<?php

namespace App\Libs\Actions;

use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Feedback actions
 */
class FeedbackAction
{
    /**
     * @var Feedback
     */
    private Feedback $model;

    /**
     * @param Feedback $model
     */
    public function __construct(Feedback $model)
    {
        $this->model = $model;
    }

    /**
     * create feedback
     * @param $request
     * @return JsonResponse
     */
    public function createFeedbackAction($request): JsonResponse
    {
        try {
            $feedback = $this->model->create([
                'market_reality' => $request->market_reality,
                'importance' => $request->importance,
                'solution_platform' => $request->solution_platform,
                'key_things' => $request->key_things,
                'ideal_relationship' => $request->ideal_relationship,
                'facility_band' => $request->facility_band,
                'patient_percentage' => $request->patient_percentage,
                'second_third_investigation' => $request->second_third_investigation,
                'perceive_hmo' => $request->perceive_hmo,
                'name'  => $request->name,
            ]);
            return response()->json([
                'message' => 'Feedback given successfully',
                'data' => new FeedbackResource($feedback),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json([
                'message' => 'Sorry unable to give feedback',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get all feedback
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllFeedbacksAction(): JsonResponse|AnonymousResourceCollection
    {
        $categories = $this->model->latest()->paginate(10);
        if (count($categories) < 1) {
            return response()->json([
                'message' => 'Sorry no feedback found',
                'success' => false
            ], 404);
        }else {
            return FeedbackResource::collection($categories)->additional([
                'message' => "All feedbacks categories",
                'success' => true
            ], 200);
        }
    }

    /**
     * get single feedback
     * @param $id
     * @return FeedbackResource
     */
    public function getSingleFeedbackAction($id): FeedbackResource
    {
        $feedback = $this->model->findOrFail($id);
        return (new FeedbackResource($feedback))->additional( [
            'message' => "Feedback details",
            'success' => true
        ], 200);
    }

    /**
     * delete feedback
     * @param $id
     * @return JsonResponse
     */
    public function deleteFeedbackAction($id): JsonResponse
    {
        $feedback =  $this->model->findOrFail($id);
        try {
            $feedback->delete();
            return response()->json([
                'message' => 'Feedback deleted successfully',
                'data' => new FeedbackResource($feedback),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete feedback',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
