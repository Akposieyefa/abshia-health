<?php

namespace App\Libs\Repositories;

use App\Libs\Repositories\Contracts\EmailVerificationRepositoryInterface;
use App\Models\AccountVerificationToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EmailVerificationRepository implements EmailVerificationRepositoryInterface
{
    /**
     * @var User
     */
    private User $model;
    /**
     * @var AccountVerificationToken
     */
    private AccountVerificationToken $token_model;

    /**
     * @param User $model
     * @param AccountVerificationToken $token_model
     */
    public  function __construct(
        User $model, AccountVerificationToken $token_model,
    )
    {
        $this->model = $model;
        $this->token_model = $token_model;
    }

    /**
     * verify email address
     * @param $request
     * @return JsonResponse
     */
    public function verifyEmailAddress($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            "token"  =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            $token = $this->token_model->where('token', '=', $request->token)->first();
            if ($token) {
                try {
                    $this->model->where('email', '=', $token->email)->update([
                        'email_verified_at' => Carbon::now()
                    ]);
                    return response()->json([
                        'message' => 'Email have  been  verified successfully',
                        'success' => true
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Sorry unable to verify email address',
                        'error' => $e->getMessage(),
                        'success' => false
                    ], 400);
                }
            }else {
                return response()->json([
                    'message' => 'Token not found',
                    'success' => false
                ], 404);
            }
        }
    }

}
