<?php

namespace App\Libs\Repositories;

use App\Http\Resources\UserResource;
use App\Libs\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuthRepository implements AuthRepositoryInterface
{

    /**
     * login user
     * @param $request
     * @return JsonResponse|void
     */
    public function login($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            $cred = request(['email', 'password']);
            if (!auth()->attempt($cred)) {
                return response()->json([
                    'message' => 'Invalid login details',
                    'success' => false
                ], 422);
            }
            if (auth()->user()->email_verified_at == NULL) {
                return response()->json([
                    'message' => 'Email must be verified',
                    'success' => false
                ], 422);

            } else {
                $token =  auth()->user()->createToken('apiToken')->plainTextToken;
                if ($token) {
                    return response()->json([
                        'token' => $token,
                        'user' => new UserResource(auth()->user()),
                        'token_type' => 'bearer',
                        'success' => true
                    ], 200);
                }
            }
        }
    }

    /**
     * logout authenticated user
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
            'success' => true
        ], 200);
    }

    /**
     * users profile
     * @return UserResource
     */
    public function userProfile(): UserResource
    {
        return new UserResource(auth()->user());
    }
}
