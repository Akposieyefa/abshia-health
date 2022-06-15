<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\EmailVerificationRepositoryInterface;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * @var EmailVerificationRepositoryInterface
     */
    private EmailVerificationRepositoryInterface $emailVerificationRepositoryInterface;

    /**
     * @param EmailVerificationRepositoryInterface $emailVerificationRepositoryInterface
     */
    public function __construct(EmailVerificationRepositoryInterface $emailVerificationRepositoryInterface)
    {
        $this->emailVerificationRepositoryInterface =  $emailVerificationRepositoryInterface;
    }

    /**
     * verify email address
     * @param Request $request
     * @return mixed
     */
    public function verify(Request $request): mixed
    {
        return $this->emailVerificationRepositoryInterface->verifyEmailAddress($request);
    }

}
