<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepositoryInterface;

    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    /**
     * create agents
     * @param Request $request
     * @return mixed
     */
    public function createAgent(Request $request): mixed
    {
        return $this->userRepositoryInterface->createAgentAccount($request);
    }

    /**
     * create hospital
     * @param Request $request
     * @return mixed
     */
    public function createHospital(Request $request): mixed
    {
        return $this->userRepositoryInterface->createHospitalAccount($request);
    }

    /**
     * get all hospitals
     * @return mixed
     */
    public function getHospitals(): mixed
    {
        return $this->userRepositoryInterface->getAllHospitals();
    }

    /**
     * get all agents
     * @return mixed
     */
    public function getAgents(): mixed
    {
        return $this->userRepositoryInterface->getAllAgent();
    }

    /**
     * change password
     * @param Request $request
     * @return mixed
     */
    public function changeAccountPassword(Request $request): mixed
    {
        return $this->userRepositoryInterface->changePassword($request);
    }

    /**
     * show account details
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
        return $this->userRepositoryInterface->getAccount($id);
    }

    /**
     * update agent account
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateAgent(Request $request, $id): mixed
    {
        return $this->userRepositoryInterface->updateAgentAccount($request, $id);
    }

    /**
     * update hospital account
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateHospital(Request $request, $id): mixed
    {
        return $this->userRepositoryInterface->updateHospitalAccount($request, $id);
    }

    /**
     * onboard new user
     * @param Request $request
     * @return mixed
     */
    public function onboardNewUser(Request $request): mixed
    {
        return $this->userRepositoryInterface->createUserAccount($request);
    }

    /**
     * get all onboarded users
     * @return mixed
     */
    public function getAllOnboardedUsers(): mixed
    {
        return $this->userRepositoryInterface->getAllEnrolledUsers();
    }

    /**
     * sign up account
     * @param Request $request
     * @return mixed
     */
    public function signUpAccount(Request $request): mixed
    {
        return $this->userRepositoryInterface->createSignUp($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateSignUpAccount(Request $request): mixed
    {
        return $this->userRepositoryInterface->updateSignUpDetails($request);
    }

    /**
     * delete account
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id): mixed
    {
        return $this->userRepositoryInterface->deleteAccount($id);
    }

}
