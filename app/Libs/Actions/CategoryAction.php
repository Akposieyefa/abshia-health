<?php

namespace App\Libs\Actions;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Category Action
 */
class CategoryAction
{
    /**
     * @var Category
     */
    private Category $model;

    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * create category
     * @param $request
     * @return JsonResponse
     */
    public function createCategoryAction($request): JsonResponse
    {
        try {
            $category = $this->model->create([
                'title' => $request->title,
                'description' => $request->description
            ]);
            return response()->json([
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to  create category',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get single category
     * @param $id
     * @return CategoryResource
     */
    public function getSingleCategoryAction($id): CategoryResource
    {
        $category = $this->model->findOrFail($id);
        return (new CategoryResource($category))->additional( [
            'message' => "Category details",
            'success' => true
        ], 200);
    }

    /**
     * get all category
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllCategoryAction(): JsonResponse|AnonymousResourceCollection
    {
        $categories = $this->model->latest()->paginate(10);
        if (count($categories) < 1) {
            return response()->json([
                'message' => 'Sorry no category found',
                'success' => false
            ], 404);
        }else {
            return CategoryResource::collection($categories)->additional([
                'message' => "All categories",
                'success' => true
            ], 200);
        }
    }

    /**
     * update category
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateCategoryAction($request, $id): JsonResponse
    {
        $category =  $this->model->findOrFail($id);
        $category->slug = null;
        try {
            $update = $category->update([
                'title' => empty($request->title) ? $category->title : $request->title,
                'description' =>   empty($request->description) ? $category->description : $request->description
            ]);
            return response()->json([
                'message' => 'Category edited successfully',
                'data' => new CategoryResource($category),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to edit category',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * delete category
     * @param $id
     * @return JsonResponse
     */
    public function deleteCategoryAction($id): JsonResponse
    {
        $category =  $this->model->findOrFail($id);
        try {
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully',
                'data' => new CategoryResource($category),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete category',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
