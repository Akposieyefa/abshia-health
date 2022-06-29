<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\ReferRepositoryInterface;
use Illuminate\Http\Request;

/**
 *
 */
class ReferController extends Controller
{
    /**
     * @var ReferRepositoryInterface
     */
    private ReferRepositoryInterface $referRepositoryInterface;

    /**
     * @param ReferRepositoryInterface $referRepositoryInterface
     */
    public function __construct(ReferRepositoryInterface $referRepositoryInterface)
    {
        $this->referRepositoryInterface = $referRepositoryInterface;
    }

    /**
     * get all refers
     * @return mixed
     */
    public function index(): mixed
    {
        return  $this->referRepositoryInterface->getAllRefer();
    }

    /**
     * store refers
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
       return  $this->referRepositoryInterface->createRefer($request);
    }

    /**
     * show sing refer
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
        return $this->referRepositoryInterface->getSingleRefer($id);
    }

}
