<?php

namespace App\Libs\Repositories;

use App\Libs\Repositories\Contracts\PaystackPaymentRepositoryInterface;
use App\Libs\Services\PaystackPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Paystack payment
 */
class PaystackPaymentRepository implements PaystackPaymentRepositoryInterface
{
    /**
     * @var PaystackPayment
     */
    private  PaystackPayment $paystack_payment_service;

    /**
     * @param PaystackPayment $paystack_payment_service
     */
    public function __construct(PaystackPayment $paystack_payment_service)
    {
        $this->paystack_payment_service = $paystack_payment_service;
    }

    /**
     * init payment
     * @param $request
     * @return JsonResponse
     */
    public function initPaymentGateway($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'type' => 'required',
            'amount' => 'required',
            'category_id' => 'sometimes',
            'description' => 'sometimes',
            'emp_code' => 'sometimes'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'success' => false
            ], 422);
        }else {
            return  $this->paystack_payment_service->initializePaystackPayment($request);
        }
    }

    /**
     * verify payment
     * @param $ref
     * @return JsonResponse
     */
    public function verifyPaystackPaymentGateway($ref): JsonResponse
    {
        return $this->paystack_payment_service->verifyPaystackPayment($ref);
    }

}
