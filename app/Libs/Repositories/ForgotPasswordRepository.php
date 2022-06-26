<?php

namespace App\Libs\Repositories;

use App\Libs\Repositories\Contracts\ForgotPasswordRepositoryInterface;
use App\Models\AccountVerificationToken;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordRepository implements ForgotPasswordRepositoryInterface
{
    /**
     * @var User
     */
    private User $model;
    /**
     * @var PasswordReset
     */
    private PasswordReset $reset_model;

    /**
     * @param User $model
     * @param PasswordReset $reset_model
     */
    public  function __construct(User $model, PasswordReset $reset_model)
    {
        $this->model = $model;
        $this->reset_model = $reset_model;
    }

    /**
     * send password reset link
     * @param $request
     * @return JsonResponse
     */
    public function sendPasswordResetLink($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);

        }else {
            $email_check = $this->model->where('email', '=', $request->email)->first();
            if ($email_check) {
                try {
                    $token = Str::random(64);
                    $this->reset_model->create([
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => now()
                    ]);
//                    $email_user = new ResetPasswordMail([
//                        'name' =>$email_check->name,
//                        'url' => $token.'&email'.$request->email
//                    ]);
//                    Mail::to($request->email)->send($email_user);
                    return response()->json([
                        'message' => 'Email link sent successfully',
                        'data' => $request->email,
                        'success' => true
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Sorry unable to create password reset token',
                        'error' => $e->getMessage(),
                        'success' => false
                    ], 400);
                }
            }else {
                return response()->json([
                    'message' => 'Sorry this email do not exist in our system',
                    'success' => false
                ], 404);
            }
        }
    }

    /**
     * reset users password
     * @param $request
     * @return JsonResponse
     */
    public function resetPassword($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            $token_check = $this->reset_model->where('email', '=', $request->email)
                ->where('token', '=', $request->token)->exists();
            if ($token_check) {
                $user = $this->model->where('email', '=', $request->email)->first();
                $hashedPassword = $user->password;
                if (!Hash::check($request->password , $hashedPassword)) {
                    try {
                        $user->update([
                            'password' => bcrypt($request->password)
                        ]);
                        $delete_token = DB::table('password_resets')->where('email', '=', $request->email)->delete();
                        return response()->json([
                            'message' => 'Password reset successfully',
                            'success' => true
                        ], 200);
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => 'Sorry the password reset process failed',
                            'error' => $e->getMessage(),
                            'success' => false
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'message' => 'Sorry new password can not be the old password!',
                        'success' => false
                    ], 401);
                }
            } else {
                return response()->json([
                    'message' => 'Sorry this email and token is invalid try again',
                    'success' => false
                ], 404);
            }
        }
    }

}
