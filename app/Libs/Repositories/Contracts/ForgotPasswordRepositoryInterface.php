<?php

namespace App\Libs\Repositories\Contracts;

interface ForgotPasswordRepositoryInterface
{
    public function sendPasswordResetLink($request);
    public function resetPassword($request);
}
