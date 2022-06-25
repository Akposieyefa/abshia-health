<?php

namespace App\Libs\Repositories;

use App\Http\Resources\FeedbackResource;
use App\Libs\Actions\FeedbackAction;
use App\Libs\Repositories\Contracts\FeedbackRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 * Feedback repository
 */
class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * @var FeedbackAction
     */
    private FeedbackAction $action;

    /**
     * @param FeedbackAction $action
     */
    public function __construct(FeedbackAction $action)
    {
        $this->action = $action;
    }

    /**
     * create feedback
     * @param $request
     * @return JsonResponse
     */
    public function createFeedback($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'market_reality' => 'required',
            'importance' => 'required',
            'solution_platform' => 'required',
            'key_things' => 'required',
            'ideal_relationship' => 'required',
            'facility_band' => 'required',
            'patient_percentage' => 'required',
            'second_third_investigation'=> 'required',
            'perceive_hmo' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createFeedbackAction($request);
        }
    }

    /**
     * get all feedback
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllFeedbacks(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllFeedbacksAction();
    }

    /**
     * get single feedback
     * @param $id
     * @return FeedbackResource
     */
    public function getSingleFeedback($id): FeedbackResource
    {
        return $this->action->getSingleFeedbackAction($id);
    }

    /**
     * delete feedback
     * @param $id
     * @return JsonResponse
     */
    public function deleteFeedback($id): JsonResponse
    {
        return $this->action->deleteFeedbackAction($id);
    }

}
