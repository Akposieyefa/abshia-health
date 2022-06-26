<?php

namespace App\Libs\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function createAgentAccount($request);
    public function createHospitalAccount($request);
    public function getAllAgent();
    public function getAllHospitals();
    public function changePassword($request);
    public function deleteAccount($id);
    public function getAccount($id);
    public function updateAgentAccount($request, $id);
    public function updateHospitalAccount($request, $id);
    public function createUserAccount($request);
    public function getAllEnrolledUsers();
    public function createSignUp($request);
    public function updateSignUpDetails($request);

}

