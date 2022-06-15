<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\ForgotPasswordRepositoryInterface;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * @var ForgotPasswordRepositoryInterface
     */
    private ForgotPasswordRepositoryInterface $forgotPasswordRepositoryInterface;

    /**
     * @param ForgotPasswordRepositoryInterface $forgotPasswordRepositoryInterface
     */
    public function __construct(ForgotPasswordRepositoryInterface $forgotPasswordRepositoryInterface)
    {
        $this->forgotPasswordRepositoryInterface = $forgotPasswordRepositoryInterface;
    }

    /**
     * send forgot password link
     * @param Request $request
     * @return mixed
     */
    public function send(Request $request): mixed
    {
        return $this->forgotPasswordRepositoryInterface->sendPasswordResetLink($request);
    }

    /**
     * reset forgot password
     * @param Request $request
     * @return mixed
     */
    public function reset(Request $request): mixed
    {
        return $this->forgotPasswordRepositoryInterface->resetPassword($request);
    }

}

