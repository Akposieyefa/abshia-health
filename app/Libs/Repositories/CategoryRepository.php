<?php

namespace App\Libs\Repositories;

use App\Http\Resources\CategoryResource;
use App\Libs\Repositories\Contracts\CategoryRepositoryInterface;
use App\Libs\Actions\CategoryAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 * Category repository
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var CategoryAction
     */
    private CategoryAction $action;

    /**
     * @param CategoryAction $action
     */
    public function __construct(CategoryAction $action)
    {
        $this->action = $action;
    }

    /**
     * create category
     * @param $request
     * @return JsonResponse
     */
    public function createCategory($request): JsonResponse
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
            return $this->action->createCategoryAction($request);
        }
    }

    /**
     * get single category
     * @param $id
     * @return CategoryResource
     */
    public function getSingleCategory($id): CategoryResource
    {
        return $this->action->getSingleCategoryAction($id);
    }

    /**
     * get all category
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllCategory(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllCategoryAction();
    }

    /**
     * update category
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateCategory($request, $id): JsonResponse
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
            return $this->action->updateCategoryAction($request, $id);
        }
    }

    /**
     * delete category
     * @param $id
     * @return JsonResponse
     */
    public function deleteCategory($id): JsonResponse
    {
        return $this->action->deleteCategoryAction($id);
    }

}
