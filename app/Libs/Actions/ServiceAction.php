<?php

namespace App\Libs\Actions;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Service Action
 */
class ServiceAction
{
    /**
     * @var Service
     */
    private Service $model;

    /**
     * @param Service $model
     */
    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    /**
     * create service
     * @param $request
     * @return JsonResponse
     */
    public function createServiceAction($request): JsonResponse
    {
        try {
            $service = $this->model->create([
                'title' => $request->title,
                'description' => $request->description
            ]);
            return response()->json([
                'message' => 'Service created successfully',
                'data' => new ServiceResource($service),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to  created service',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get single service
     * @param $id
     * @return ServiceResource
     */
    public function getSingleServiceAction($id): ServiceResource
    {
        $service = $this->model->findOrFail($id);
        return (new ServiceResource($service))->additional( [
            'message' => "Service details",
            'success' => true
        ], 200);
    }

    /**
     * get all service
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllServiceAction(): JsonResponse|AnonymousResourceCollection
    {
        $services = $this->model->latest()->paginate(10);
        if (count($services) < 1) {
            return response()->json([
                'message' => 'Sorry no service found',
                'success' => false
            ], 404);
        }else {
            return ServiceResource::collection($services)->additional([
                'message' => "All services",
                'success' => true
            ], 200);
        }
    }

    /**
     * update service
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateServiceAction($request, $id): JsonResponse
    {
        $service =  $this->model->findOrFail($id);
        $service->slug = null;
        try {
            $service->update([
                'title' => empty($request->title) ? $service->title : $request->title,
                'description' =>   empty($request->description) ? $service->description : $request->description
            ]);
            return response()->json([
                'message' => 'Service edited successfully',
                'data' => new ServiceResource($service),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to edit service',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * delete service
     * @param $id
     * @return JsonResponse
     */
    public function deleteServiceAction($id): JsonResponse
    {
        $service =  $this->model->findOrFail($id);
        try {
            $service->delete();
            return response()->json([
                'message' => 'Service deleted successfully',
                'data' => new ServiceResource($service),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete service',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
