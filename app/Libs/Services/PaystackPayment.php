<?php

namespace App\Libs\Services;

use App\Models\Enrolle;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Libs\Helpers\SystemHelper;
use App\Http\Resources\UserResource;

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
     * @var SystemHelper
     */
    private SystemHelper $helper;

    /**
     * @param Transaction $transaction_model
     * @param Enrolle $enrolle_model
     * @param SystemHelper $helper
     */
    public function __construct(Transaction $transaction_model, Enrolle $enrolle_model, SystemHelper $helper)
    {
        $this->transaction_model = $transaction_model;
        $this->enrolle_model = $enrolle_model;
        $this->helper = $helper;
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
                'from_date' => now(),
                'to_date' =>  $this->helper->subscriptionDurationHelper($request->plan_id),
                'is_subscribed' => true,
                'plan_id' => $request->plan_id
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
            'enrolle_id' => auth()->user()->enrolle ? auth()->user()->enrollee->id : $this->helper->getEnrolleeIdByUserID($request->emp_id),
            'trans_ref' => $paymentReference,
            'amount' => $request->amount,
            'description' => $request->type,
            'payment_gateway' => $gateway,
            'plan_id' => $request->plan_id,
            'status' => true,
        ]);
    }

}
