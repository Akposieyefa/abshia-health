<?php

namespace App\Libs\Services;

use App\Http\Resources\UserResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Yabacon\Paystack;
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
     * @var Paystack
     */
    private Paystack $paystack;
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
        $this->paystack = new Paystack(config('abshia-config.paystack.paystack_secret'));
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
            $trx = $this->paystack->transaction->initialize(
                [
                    'amount' => $tr->amount * 100, /* in kobo */
                    'email' => auth()->user()->email,
                    'reference' => $tr->trans_ref,
                    'callback_url' => config('abshia-config.front_end_url'),
                    'metadata' => [
                        'user_id' => $tr->user_id,
                        'reference' => $tr->trans_ref,
                        'transaction_id' => $tr->id,
                        'total' => $tr->amount,
                    ],
                ]
            );
            return response()->json([
                'message' => 'Paystack transaction link generated successfully',
                'url' => $trx->data->authorization_url,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry there was an error trying to generate payment link',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * verify paystack unit
     * @param $reference
     * @return JsonResponse
     */
    public function verifyPaystackPayment($reference): JsonResponse
    {
        if (!$reference) {
            return response()->json([
                'message' => 'Sorry No reference token supplied',
                'success' => false
            ], 404);
        }
        try {
            $trx = $this->paystack->transaction->verify([
                'reference' => $reference
            ]);
            $trans_ref = $trx->data->metadata->reference;
            $transType = $this->transaction_model->where('trans_ref', '=', $trans_ref)->where('user_id','=',auth()->user()->id)->first();
            $transType->update([
                'status' => true,
            ]);
            $this->enrolle_model->where('user_id', '=', auth()->user()->id)->update([
                'is_subscribed' => true
            ]);
            return response()->json([
                'message' => 'Payment successful',
                'data' => new UserResource(auth()->user()),
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry the verification process failed',
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
            'category_id' => $request->category_id
        ]);
    }

}
