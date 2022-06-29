<?php

namespace App\Libs\Repositories;

use App\Http\Resources\ReferResource;
use App\Libs\Actions\ReferAction;
use App\Libs\Repositories\Contracts\ReferRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class ReferRepository implements ReferRepositoryInterface
{
    /**
     * @var ReferAction
     */
    private ReferAction $action;

    /**
     * @param ReferAction $action
     */
    public function __construct(ReferAction $action)
    {
        $this->action = $action;
    }

    /**
     * crete refer
     * @param $request
     * @return JsonResponse
     */
    public function createRefer($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'emp_code' => 'required',
            'case' => 'required',
            'hospital_name' => 'required',
            'remark' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return  $this->action->createReferAction($request);
        }
    }

    /**
     * get all refers
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllRefer(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllReferAction();
    }

    /**
     * get single refer
     * @param $id
     * @return ReferResource
     */
    public function getSingleRefer($id): ReferResource
    {
        return $this->action->getSingleReferAction($id);
    }

}
