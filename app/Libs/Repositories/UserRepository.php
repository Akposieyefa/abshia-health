<?php

namespace App\Libs\Repositories;

use App\Http\Resources\UserResource;
use App\Libs\Repositories\Contracts\UserRepositoryInterface;
use App\Libs\Actions\UserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Utils;

/**
 * user repository
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserAction
     */
    private  UserAction $action;

    /**
     * @param UserAction $action
     */
    public function __construct(UserAction $action)
    {
        $this->action = $action;
    }

    /**
     * create agents
     * @param $request
     * @return JsonResponse
     */
    public function createAgentAccount($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'lga_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createAgentAccountAction($request);
        }
    }

    /**
     * create hospitals
     * @param $request
     * @return JsonResponse
     */
    public function createHospitalAccount($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'lga_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createHospitalAccountAction($request);
        }
    }

    /**
     * change password
     * @param $request
     * @return JsonResponse
     */
    public function changePassword($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->changePasswordAction($request);
        }
    }

    /**
     * get all agents
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllAgent(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllAgentAction();
    }

    /**
     * get all hospitals
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllHospitals(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllHospitalAction();
    }

    /**
     * get account action
     * @param $id
     * @return UserResource
     */
    public function getAccount($id): UserResource
    {
        return $this->action->getAccountAction($id);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function createUserAccount($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'title' => 'required',
            'surname' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'blood_group' => 'required',
            'town' => 'required',
            'nok_name' => 'required',
            'nok_address' => 'required',
            'nok_phone' => 'required',
            'nok_relationship' => 'required',
            'category_id' => 'required',
            'agent_code' => 'sometimes',
            'genotype' => 'required',
            'marital_status' => 'required',
            'no_of_dependants' => 'required',
            'health_care_id' => 'required',
            'existing_medical_condition' => 'required',
            'hypertension' => 'required',
            'sickle_cell' => 'required',
            'cancer' => 'required',
            'state_id' => 'required',
            'lga_id' => 'required',
            'kidney_issue' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createUserAccountAction($request);
        }
    }

    /**
     * create sign up for users
     * @param $request
     * @return JsonResponse
     */
    public function createSignUp($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'surname' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->createSignUpAction($request);
        }
    }

    /**
     * update sign up details
     * @param $request
     * @return JsonResponse
     */
    public function updateSignUpDetails($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'address' => 'required',
            'title' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'blood_group' => 'required',
            'town' => 'required',
            'nok_name' => 'required',
            'nok_address' => 'required',
            'nok_phone' => 'required',
            'nok_relationship' => 'required',
            'category_id' => 'required',
            'agent_code' => 'sometimes',
            'genotype' => 'required',
            'marital_status' => 'required',
            'no_of_dependants' => 'required',
            'health_care_id' => 'required',
            'existing_medical_condition' => 'required',
            'hypertension' => 'required',
            'sickle_cell' => 'required',
            'cancer' => 'required',
            'state_id' => 'required',
            'lga_id' => 'required',
            'kidney_issue' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return  $this->action->updateOnboardProcessAction($request);
        }
    }

    /**
     * get all enrolled users
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllEnrolledUsers(): JsonResponse|AnonymousResourceCollection
    {
        return $this->action->getAllEnrolledUsersAction();
    }

    /**
     * update agent account
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateAgentAccount($request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'phone_number' => 'sometimes',
            'address' => 'sometimes',
            'lga_id' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->updateAgentAccountAction($request, $id);
        }
    }

    /**
     * update hospital account
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateHospitalAccount($request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'phone_number' => 'sometimes',
            'address' => 'sometimes',
            'lga_id' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], 422);
        }else {
            return $this->action->updateHospitalAccountAction($request, $id);
        }
    }

    /**
     * delete account
     * @param $id
     * @return JsonResponse
     */
    public function deleteAccount($id): JsonResponse
    {
        return $this->action->deleteAccountActon($id);
    }
}
