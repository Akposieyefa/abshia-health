<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\PaystackPaymentRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Paystack payment controller
 */
class PaystackPaymentController extends Controller
{
    /**
     * @var PaystackPaymentRepositoryInterface
     */
    private  PaystackPaymentRepositoryInterface $paystackPaymentRepositoryInterface;

    /**
     * @param PaystackPaymentRepositoryInterface $paystackPaymentRepositoryInterface
     */
    public function __construct(PaystackPaymentRepositoryInterface $paystackPaymentRepositoryInterface)
    {
        $this->paystackPaymentRepositoryInterface = $paystackPaymentRepositoryInterface;
    }

    /**
     * make payment
     * @param Request $request
     * @return mixed
     */
    public function payment(Request $request): mixed
    {
        return $this->paystackPaymentRepositoryInterface->initPaymentGateway($request);
    }

    /**
     * verify payment
     * @param $ref
     * @return mixed
     */
    public function verifyPaystack($ref): mixed
    {
        return $this->paystackPaymentRepositoryInterface->verifyPaystackPaymentGateway($ref);
    }

}
