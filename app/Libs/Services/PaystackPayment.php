<?php

namespace App\Libs\Services;

use App\Http\Resources\UserResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Models\Enrolle;

/**
 * Paystack payment service
 */
class PaystackPayment
{
    /**
     * @var Transaction
     */
    private Transaction $transaction_model;
    /**
     * @var Enrolle
     */
    private  Enrolle $enrolle_model;

    /**
     * @param Transaction $transaction_model
     * @param Enrolle $enrolle_model
     */
    public function __construct(Transaction $transaction_model, Enrolle $enrolle_model)
    {
        $this->transaction_model = $transaction_model;
        $this->enrolle_model = $enrolle_model;
    }

    /**
     * initialize stripe payment
     * @param $request
     * @return JsonResponse
     */
    public function initializePaystackPayment($request): JsonResponse
    {
        $tr = $this->createTransaction($request, 'paystack');
        try {
            $this->enrolle_model->where('user_id', '=', auth()->user()->id)->update([
                'is_subscribed' => true
            ]);
            return response()->json([
                'message' => 'Payment made successfully',
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to create payment',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }


    /**
     * create transaction record
     * @param $request
     * @param $gateway
     * @return mixed
     */
    public function createTransaction($request, $gateway): mixed
    {
        $paymentReference = "VS" . sprintf("%0.9s", str_shuffle(rand(12, 30000) * time()));
        return $this->transaction_model->create([
            'type' => $request->type,
            'enrolle_id' => auth()->user()->enrollee->id,
            'trans_ref' => $paymentReference,
            'amount' => $request->amount,
            'description' => $request->type,
            'payment_gateway' => $gateway,
            'plan_id' => $request->plan_id,
            'status' => true,
        ]);
    }

}