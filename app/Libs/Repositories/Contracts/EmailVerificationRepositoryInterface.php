<?php

namespace App\Libs\Repositories\Contracts;

interface EmailVerificationRepositoryInterface
{
    public function verifyEmailAddress($request);
}
