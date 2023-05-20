<?php

namespace App\Libs\Helpers;

use App\Models\Plan;
use Carbon\Carbon;
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
                'agents' =>  DB::table('users')->whereNull('deleted_at')->where('role', '=', 'agent')->count(),
                'hospitals' =>  DB::table('users')->whereNull('deleted_at')->where('role', '=', 'hospital')->count(),
                'services' => DB::table('services')->whereNull('deleted_at')->count(),
                'enrolled_users' => DB::table('users')->whereNull('deleted_at')->where('role', '=', 'user')->count()
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
                'appointments' => DB::table('appointments')->where('health_care_id', '=', auth()->user()->hospital->id)->count(),
                'treatments' => DB::table('treatments')->where('health_care_id', '=', auth()->user()->hospital->id)->count()
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

    /**
     * generate random code
     * @param $number
     * @return string
     */
    public function generateRandomOtp($number): string
    {
        $today = date('YmdHis');
        $characters = '0123456789';
        $main = $today."". $characters;
        $randomString = '';
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, strlen($main) - 1);
            $randomString .= $main[$index];
        }
        return $randomString;
    }

    /**
     * get agent id
     * @param $code
     * @return mixed
     */
    public function getAgentId($code): mixed
    {
        $agent_id = DB::table('agents')->where('ref_code', '=', $code)->first();
        return $agent_id->id;
    }

    /**
     * get enroll id
     * @param $code
     * @return mixed
     */
    public function getEnrolleeId($code): mixed
    {
        $enrollee_id = DB::table('enrolles')->where('emp_id', '=', $code)->first();
        return $enrollee_id->id;
    }

    /**
     * get enroll id
     * @param $id
     * @return mixed
     */
    public function getEnrolleeIdByUserID($id): mixed
    {
        $enrollee_id = DB::table('enrolles')->where('user_id', '=', $id)->first();
        return $enrollee_id->id;
    }

      /**
     * convert money to kobo
     * @param $amount
     * @return float|int
     */
    public function convertToKobo($amount): float|int
    {
        return $amount * 100;
    }

    /**
     * convert kobo to naira
     * @param $amount
     * @return float|int
     */
    public function convertKoboToNaira($amount): float|int
    {
        return $amount / 100;
    }

    /**
     * subscription duration
     * @param $id
     * @return Carbon
     */
    public function subscriptionDurationHelper($id): Carbon
    {
        $end_date = null;
        $plan = Plan::find($id);
        $du = $plan->duration;
        if ($du == 'Three Month') {
            $end_date = Carbon::now()->addMonths(3);
        }elseif ($du == 'Six Month') {
            $end_date = Carbon::now()->addMonths(6);
        }elseif ($du == 'One Year') {
            $end_date = Carbon::now()->addMonths(12);
        }else {
            $end_date = Carbon::now()->addMonths(1);
        }
        return $end_date;
    }



}
