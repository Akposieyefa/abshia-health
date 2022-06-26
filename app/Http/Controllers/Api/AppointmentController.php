<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\AppointmentRepositoryInterface;
use Illuminate\Http\Request;

/**
 *
 */
class AppointmentController extends Controller
{
    /**
     * @var AppointmentRepositoryInterface
     */
    private AppointmentRepositoryInterface $appointmentRepositoryInterface;

    /**
     * @param AppointmentRepositoryInterface $appointmentRepositoryInterface
     */
    public function __construct(AppointmentRepositoryInterface $appointmentRepositoryInterface)
   {
       $this->appointmentRepositoryInterface = $appointmentRepositoryInterface;
   }

    /**
     * get all appointment
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->appointmentRepositoryInterface->getAllAppointment();
    }

    /**
     * create appointment
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->appointmentRepositoryInterface->createAppointment($request);
    }

    /**
     * show single appointment
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
       return $this->appointmentRepositoryInterface->getSingleAppointment($id);
    }

    /**
     * approve appointment
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id): mixed
    {
        return $this->appointmentRepositoryInterface->approveAppointment($request, $id);
    }

    /**
     * decline appointment request
     * @param $id
     * @return mixed
     */
    public function declineAppointment($id): mixed
    {
        return $this->appointmentRepositoryInterface->cancelAppointment($id);
    }

    /**
     * delete appointment
     * @param $id
     * @return mixed
     */
    public function destroy($id): mixed
    {
        return $this->appointmentRepositoryInterface->deleteAppointment($id);
    }

}
