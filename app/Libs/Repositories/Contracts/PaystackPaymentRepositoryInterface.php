<?php

namespace App\Libs\Repositories\Contracts;

interface PaystackPaymentRepositoryInterface
{
    public function initPaymentGateway($request);
    public function verifyPaystackPaymentGateway($ref);
}
