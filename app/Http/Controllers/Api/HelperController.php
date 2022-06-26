<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Libs\Helpers\SystemHelper;

/**
 *
 */
class HelperController extends Controller
{
    /**
     * @var SystemHelper
     */
    private SystemHelper $helper;

    /**
     * @param SystemHelper $helper
     */
    public function __construct(SystemHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * get all lga in Abia state
     * @return JsonResponse
     */
    public function allLga(): JsonResponse
    {
        return $this->helper->getLga();
    }

    /**
     * dashboard matrix helper
     * @return JsonResponse
     */
    public function dashBoardCounts(): JsonResponse
    {
        return $this->helper->dashBoardCountHelper();
    }

    /**
     * create state helper
     * @return JsonResponse
     */
    public function createUserHelper(): JsonResponse
    {
        return $this->helper->createHelper();
    }

    /**
     * get lga by state helper
     * @param $id
     * @return JsonResponse
     */
    public function getLgaByStateId($id): JsonResponse
    {
        return $this->helper->getLgaHelper($id);
    }

    /**
     * hospital matrix
     * @return JsonResponse
     */
    public function getHospitalDashboardMatrix(): JsonResponse
    {
        return $this->helper->dashBoardCountHelperForHospital();
    }

}
