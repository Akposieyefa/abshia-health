<?php

namespace App\Libs\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class SystemHelper
{
    /**
     * clean string helper
     * @param $string
     * @return mixed
     */
    public function cleanStringHelper($string): mixed
    {
        if (is_null($string)) {
            return "";
        }else {
            return $string;
        }
    }

    /**
     * get lgas
     * @return JsonResponse
     */
    public function getLga(): JsonResponse
    {
        return response()->json([
            "data" => [
                'lgas' => DB::table('lgas')->where('state_id', '=', 1)->get(),
            ]
        ], 200);
    }

    /**
     * dashboard
     * @return JsonResponse
     */
    public function dashBoardCountHelper(): JsonResponse
    {
        return response()->json([
            "data" => [
                'agents' =>  DB::table('users')->where('role', '=', 'agent')->count(),
                'hospitals' =>  DB::table('users')->where('role', '=', 'hospital')->count(),
                'services' => DB::table('services')->count(),
                'enrolled_users' => DB::table('users')->where('role', '=', 'user')->count()
            ]
        ], 200);
    }

    /**
     * dashboard for hospital
     * @return JsonResponse
     */
    public function dashBoardCountHelperForHospital(): JsonResponse
    {
        return response()->json([
            "data" => [
                'patients' =>  DB::table('enrolles')->where('health_care_id', '=', auth()->user()->hospital->id)->count(),
                'appointments' => DB::table('services')->count(),
                'treatments' => DB::table('services')->count()
            ]
        ], 200);
    }

    /**
     * create helper
     * @return JsonResponse
     */
    public function createHelper(): JsonResponse
    {
        return response()->json([
            "data" => [
                'hospitals' =>  DB::table('health_cares')->get(),
                'categories' => DB::table('categories')->get(),
                'states' => DB::table('states')->get()
            ]
        ], 200);
    }

    /**
     * get lga by state id
     * @param $id
     * @return JsonResponse
     */
    public function getLgaHelper($id): JsonResponse
    {
        return response()->json([
            "data" => [
                'lgas' =>  DB::table('lgas')->where('state_id', '=', $id)->get(),
            ]
        ], 200);
    }

}
