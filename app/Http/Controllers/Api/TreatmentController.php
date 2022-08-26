<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\TreatmentRepositoryInterface;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\True_;

/**
 * Treatment controller
 */
class TreatmentController extends Controller
{
    /**
     * @var TreatmentRepositoryInterface
     */
    private TreatmentRepositoryInterface $treatmentRepositoryInterface;

    /**
     * @param TreatmentRepositoryInterface $treatmentRepositoryInterface
     */
    public function __construct(TreatmentRepositoryInterface $treatmentRepositoryInterface)
    {
        $this->treatmentRepositoryInterface = $treatmentRepositoryInterface;
    }

    /**
     * get all treatment
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->treatmentRepositoryInterface->getAllTreatments();
    }

    /**
     * create treatment
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->treatmentRepositoryInterface->createTreatment($request);
    }

    /**
     * create treatment
     * @param Request $request
     * @return mixed
     */
    public function getEnrolleTreatment($id): mixed
    {
        return $this->treatmentRepositoryInterface->getTreatmentByEnrolleID($id);
    }

    /**
     * get single treatment
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
        return $this->treatmentRepositoryInterface->getSingleTreatment($id);
    }

    /**
     * delete treatment
     * @param $id
     * @return mixed
     */
    public function destroy($id): mixed
    {
        return $this->treatmentRepositoryInterface->deleteTreatment($id);
    }

}
