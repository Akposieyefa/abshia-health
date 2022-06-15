<?php

namespace App\Libs\Repositories\Contracts;

interface AppointmentRepositoryInterface
{
    public function createAppointment($request);
    public function getAllAppointment();
    public function getSingleAppointment($id);
    public function approveAppointment($request, $id);
    public function cancelAppointment($id);
    public function deleteAppointment($id);
}
