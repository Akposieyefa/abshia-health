<?php

namespace App\Libs\Actions;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Appointment action
 */
class AppointmentAction
{
    /**
     * @var Appointment
     */
    private Appointment $model;

    /**
     * @param Appointment $model
     */
    public function __construct(Appointment $model)
    {
        $this->model = $model;
    }

    /**
     * create new appointment
     * @param $request
     * @return JsonResponse
     */
    public function createAppointmentAction($request): \Illuminate\Http\JsonResponse
    {
        try {
            $appointment = $this->model->create([
                'enrolle_id' => auth()->user()->enrollee->id,
                'health_care_id' => auth()->user()->enrollee->health_care_id,
                'title' => $request->title,
                'appointment_reason' => $request->appointment_reason,
                'appointment_date' => $request->appointment_date
            ]);
            return response()->json([
                'message' => 'Appointment booked successfully',
                'data' => new AppointmentResource($appointment),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to book appointment',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * get all appointments
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllAppointmentAction(): \Illuminate\Http\JsonResponse|AnonymousResourceCollection
    {
        if (auth()->user()->role == 'superadmin'){
            $appointments = $this->model->with(['enrolle'])->latest()->paginate(10);
        } elseif(auth()->user()->role == 'hospital') {
            $appointments = $this->model->where('health_care_id', '=', auth()->user()->hospital->id)->with(['enrolle'])->latest()->paginate(10);
        } else {
            $appointments = $this->model->where('enrolle_id', '=', auth()->user()->enrollee->id)->latest()->paginate(10);
        }

        if (count($appointments) < 1) {
            return response()->json([
                'message' => 'Sorry no appointment found',
                'success' => false
            ], 404);
        }else {
            return AppointmentResource::collection($appointments)->additional([
                'message' => "Appointments fetched successfully",
                'success' => true
            ], 200);
        }
    }

    /**
     * get single appointment
     * @param $id
     * @return AppointmentResource
     */
    public function getSingleAppointmentAction($id): AppointmentResource
    {
        $category = $this->model->findOrFail($id);
        return (new AppointmentResource($category))->additional( [
            'message' => "Appointment details",
            'success' => true
        ], 200);
    }

    /**
     * approve appointment
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function approveAppointmentAction($request, $id): JsonResponse
    {
        $appointment =  $this->model->findOrFail($id);
        try {
            $appointment->update([
                'status' => 'approved',
                'approved_date' => $request->approved_date,
                'approval_comment' => $request->approved_comment
            ]);
            return response()->json([
                'message' => 'Appointment approved successfully',
                'data' => new AppointmentResource($appointment),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to approve appointment',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * cancel appointment
     * @param $id
     * @return JsonResponse
     */
    public function cancelAppointmentAction($id): JsonResponse
    {
        $appointment =  $this->model->findOrFail($id);
        try {
            $appointment->update([
                'status' => 'canceled',
            ]);
            return response()->json([
                'message' => 'Appointment Canceled successfully',
                'data' => new AppointmentResource($appointment),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to cancel appointment',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * delete appointment
     * @param $id
     * @return JsonResponse
     */
    public function deleteAppointmentAction($id): JsonResponse
    {
        $appointment =  $this->model->findOrFail($id);
        try {
            $appointment->delete();
            return response()->json([
                'message' => 'Appointment deleted successfully',
                'data' => new AppointmentResource($appointment),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete appointment',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
