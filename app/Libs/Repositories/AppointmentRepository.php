<?php

namespace App\Libs\Repositories;

use App\Http\Resources\AppointmentResource;
use App\Libs\Actions\AppointmentAction;
use App\Libs\Repositories\Contracts\AppointmentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class AppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     * @var AppointmentAction
     */
    private  AppointmentAction $action;

    /**
     * @param AppointmentAction $action
     */
    public function __construct(AppointmentAction $action)
    {
        $this->action = $action;
    }

    /**
     * create appointment
     * @param $request
     * @return JsonResponse
     */
    public function createAppointment($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'appointment_reason' => 'required',
            'appointment_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createAppointmentAction($request);
        }
    }

    /**
     * get all appointments
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllAppointment(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllAppointmentAction();
    }

    /**
     * get single appointment
     * @param $id
     * @return AppointmentResource
     */
    public function getSingleAppointment($id): AppointmentResource
    {
        return $this->action->getSingleAppointmentAction($id);
    }

    /**
     * approve appointment
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function approveAppointment($request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'approved_date' => 'required',
            'approval_comment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->approveAppointmentAction($request, $id);
        }
    }

    /**
     * cancel appointment
     * @param $id
     * @return JsonResponse
     */
    public function cancelAppointment($id): JsonResponse
    {
        return $this->action->cancelAppointmentAction($id);
    }

    /**
     * delete appointment
     * @param $id
     * @return JsonResponse
     */
    public function deleteAppointment($id): JsonResponse
    {
        return $this->action->deleteAppointmentAction($id);
    }

}
