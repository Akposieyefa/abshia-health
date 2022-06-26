<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 *
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private  CategoryRepositoryInterface $categoryRepositoryInterface;

    /**
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     */
    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return  $this->categoryRepositoryInterface->getAllCategory();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
       return $this->categoryRepositoryInterface->createCategory($request);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        return  $this->categoryRepositoryInterface->getSingleCategory($id);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id): mixed
    {
        return $this->categoryRepositoryInterface->updateCategory($request, $id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return $this->categoryRepositoryInterface->deleteCategory($id);
    }

}
