<?php

namespace App\Libs\Repositories;

use App\Http\Resources\ServiceResource;
use App\Libs\Repositories\Contracts\ServiceRepositoryInterface;
use App\Libs\Actions\ServiceAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Service repository
 */
class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @var ServiceAction
     */
    private ServiceAction $action;

    /**
     * @param ServiceAction $action
     */
    public function __construct(ServiceAction $action)
    {
        $this->action = $action;
    }

    /**
     * create service
     * @param $request
     * @return JsonResponse
     */
    public function createService($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createServiceAction($request);
        }
    }

    /**
     * get single service
     * @param $id
     * @return ServiceResource
     */
    public function getSingleService($id): ServiceResource
    {
        return $this->action->getSingleServiceAction($id);
    }

    /**
     * get all services
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllService(): JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $this->action->getAllServiceAction();
    }

    /**
     * update service
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateService($request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes',
            'description' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->updateServiceAction($request, $id);
        }
    }

    /**
     * delete service
     * @param $id
     * @return JsonResponse
     */
    public function deleteService($id): JsonResponse
    {
        return $this->action->deleteServiceAction($id);
    }

}
