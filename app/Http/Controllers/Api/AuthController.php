<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var AuthRepositoryInterface
     */
    private AuthRepositoryInterface $authRepositoryInterface;

    /**
     * @param AuthRepositoryInterface $authRepositoryInterface
     */
    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }

    /**
     * login
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request): mixed
    {
        return $this->authRepositoryInterface->login($request);
    }

    /**
     * logout
     * @return mixed
     */
    public function logout(): mixed
    {
        return $this->authRepositoryInterface->logout();
    }

    /**
     * user profile
     * @return mixed
     */
    public function userProfile(): mixed
    {
        return $this->authRepositoryInterface->userProfile();
    }

}
