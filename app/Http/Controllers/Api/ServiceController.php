<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 *
 */
class ServiceController extends Controller
{
    /**
     * @var ServiceRepositoryInterface
     */
    private ServiceRepositoryInterface $serviceRepositoryInterface;

    /**
     * @param ServiceRepositoryInterface $serviceRepositoryInterface
     */
    public function __construct(ServiceRepositoryInterface $serviceRepositoryInterface)
    {
        $this->serviceRepositoryInterface = $serviceRepositoryInterface;
    }

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return  $this->serviceRepositoryInterface->getAllService();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->serviceRepositoryInterface->createService($request);
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        return $this->serviceRepositoryInterface->getSingleService($id);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id): mixed
    {
        return $this->serviceRepositoryInterface->updateService($request, $id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return $this->serviceRepositoryInterface->deleteService($id);
    }
}
