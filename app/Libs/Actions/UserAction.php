<?php

namespace App\Libs\Actions;

use App\Http\Resources\UserResource;
use App\Libs\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Libs\Helpers\SystemHelper;

/**
 * use action
 */
class UserAction
{
    /**
     * @var User
     */
    private  User $model;
    /**
     * @var SystemHelper
     */
    private SystemHelper $helper;

    /**
     * @param User $model
     * @param SystemHelper $helper
     */
    public function __construct(User $model, SystemHelper $helper)
    {
        $this->model = $model;
        $this->helper = $helper;
    }

    /**
     * create agents
     * @param $request
     * @return JsonResponse
     */
    public function createAgentAccountAction($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create([
                'email' => $request->email,
                'password' => bcrypt('password'),
                'role' => RolesEnum::AGENT,
                'email_verified_at' => now(),
            ]);
            $user->agent()->create([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'lga_id' => $request->lga_id,
                'ref_code' => $this->helper->generateRandomOtp(5)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Sorry unable to  created agent',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
        DB::commit();
        return response()->json([
            'message' => 'Agent created successfully',
            'data' => new UserResource($this->model->find($user->id)),
            'success' => true
        ], 201);
    }

    /**
     * create hospitals
     * @param $request
     * @return JsonResponse
     */
    public function createHospitalAccountAction($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create([
                'email' => $request->email,
                'password' => bcrypt('password'),
                'role' => RolesEnum::HOSPITAL,
                'email_verified_at' => now(),
            ]);
            $user->hospital()->create([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'lga_id' => $request->lga_id,
                'ref_code' => $this->helper->generateRandomOtp(5)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Sorry unable to  created hospital',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
        DB::commit();
        return response()->json([
            'message' => 'Hospital created successfully',
            'data' => new UserResource($this->model->find($user->id)),
            'success' => true
        ], 201);
    }

    /**
     * create sign up for user
     * @param $request
     * @return JsonResponse
     */
    public function createSignUpAction($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => RolesEnum::USER,
                'email_verified_at' => now(),
            ]);
            $user->enrollee()->create([
                'user_id' => $user->id,
                'emp_id' => $this->helper->generateRandomOtp(5),
                'surname' => $request->surname
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Sorry unable to  created account',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
        DB::commit();
        return response()->json([
            'message' => 'Account created successfully'. $user->enrollee()->emp_id,
            'data' => new UserResource($this->model->find($user->id)),
            'success' => true
        ], 201);
    }

    /**
     * update boarding process
     * @param $request
     * @return JsonResponse
     */
    public function updateOnboardProcessAction($request): JsonResponse
    {
        $user = $this->model->findOrFail(auth()->user()->id);
        try {
            $user->enrollee()->update([
                'title' => $request->title,
                'surname' => $request->surname,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'dob' => $request->input('dob', date('Y-m-d')),
                'address' => $request->address,
                'blood_group' => $request->blood_group,
                'state_id' => $request->state_id,
                'lga_id' => $request->lga_id,
                'town' => $request->town,
                'nok_name' => $request->nok_name,
                'nok_address' => $request->nok_address,
                'nok_phone' => $request->nok_phone,
                'nok_relationship' => $request->nok_relationship,
                'category_id' => $request->category_id,
                'genotype' => $request->genotype,
                'marital_status' => $request->marital_status,
                'no_of_dependants' => $request->no_of_dependants,
                'health_care_id' => $request->health_care_id,
                'existing_medical_condition' => $request->existing_medical_condition,
                'hypertension' => filter_var($request->hypertension, FILTER_VALIDATE_BOOLEAN) ,
                'sickle_cell' => filter_var($request->sickle_cell, FILTER_VALIDATE_BOOLEAN),
                'cancer' => filter_var($request->cancer, FILTER_VALIDATE_BOOLEAN),
                'kidney_issue' => filter_var($request->kidney_issue, FILTER_VALIDATE_BOOLEAN)
            ]);
            return response()->json([
                'message' => 'Account updated successfully',
                'data' => new UserResource($this->model->find($user->id)),
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to  created account',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * create enrolled users
     * @param $request
     * @return JsonResponse
     */
    public function createUserAccountAction($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create([
                'email' => $request->email,
                'password' => bcrypt('password'),
                'role' => RolesEnum::USER,
                'email_verified_at' => now(),
            ]);
            $user->enrollee()->create([
                'user_id' => $user->id,
                'emp_id' => $this->helper->generateRandomOtp(5),
                'agent_id' => empty($request->agent_code) ? null : $this->helper->getAgentId($request->agent_code),
                'title' => $request->title,
                'surname' => $request->surname,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'dob' => $request->input('dob', date('Y-m-d')),
                'address' => $request->address,
                'blood_group' => $request->blood_group,
                'state_id' => $request->state_id,
                'lga_id' => $request->lga_id,
                'town' => $request->town,
                'nok_name' => $request->nok_name,
                'nok_address' => $request->nok_address,
                'nok_phone' => $request->nok_phone,
                'nok_relationship' => $request->nok_relationship,
                'category_id' => $request->category_id,
                'genotype' => $request->genotype,
                'marital_status' => $request->marital_status,
                'no_of_dependants' => $request->no_of_dependants,
                'health_care_id' => $request->health_care_id,
                'existing_medical_condition' => $request->existing_medical_condition,
                'hypertension' => filter_var($request->hypertension, FILTER_VALIDATE_BOOLEAN) ,
                'sickle_cell' => filter_var($request->sickle_cell, FILTER_VALIDATE_BOOLEAN),
                'cancer' => filter_var($request->cancer, FILTER_VALIDATE_BOOLEAN),
                'kidney_issue' => filter_var($request->kidney_issue, FILTER_VALIDATE_BOOLEAN)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Sorry unable to  created account',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
        DB::commit();
        return response()->json([
            'message' => 'Account created successfully',
            'data' => new UserResource($this->model->find($user->id)),
            'success' => true
        ], 201);
    }

    /**
     * get all agents
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllAgentAction(): JsonResponse|AnonymousResourceCollection
    {
        $agents = $this->model->where('role', '=', RolesEnum::AGENT)->latest()->paginate(10);
        if (count( $agents) < 1) {
            return response()->json([
                'message' => 'Sorry no agent found',
                'success' => false
            ], 404);
        }else {
            return UserResource::collection($agents)->additional([
                'message' => "All agents",
                'success' => true
            ], 200);
        }
    }

    /**
     * get all enrolled users account
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllEnrolledUsersAction(): JsonResponse|AnonymousResourceCollection
    {
        if (auth()->user()->role == 'superadmin'){
            $enrolled_users = $this->model->where('role', '=', RolesEnum::USER)->latest()->paginate(10);
        } else {
            $enrolled_users = $this->model->where('role', '=', RolesEnum::USER)
                ->whereHas('enrollee', function ($query) {
                    $query->where('health_care_id', '=', auth()->user()->hospital->id);
                })->latest()->paginate(10);
        }
        if (count($enrolled_users) < 1) {
            return response()->json([
                'message' => 'Sorry no enrolled users found',
                'success' => false
            ], 404);
        }else {
            return UserResource::collection($enrolled_users)->additional([
                'message' => "All  enrolled users",
                'success' => true
            ], 200);
        }
    }

    /**
     * change user password
     * @param $request
     * @return JsonResponse
     */
    public function changePasswordAction($request): JsonResponse
    {
        $user = $this->model->findOrFail(auth()->user()->id);

        $hashedPassword = $user->password;

        if (Hash::check($request->old_password , $hashedPassword)) {

            if (!Hash::check($request->password , $hashedPassword)) {

                try {
                    $user->update([
                        'password' => empty($request->password) ? $user->password : bcrypt($request->password),
                    ]);
                    return response()->json([
                        'message' => 'You have changed your password successfully',
                        'data' => new UserResource($user),
                        'success' => true
                    ], 200);

                }catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Sorry the change password process failed',
                        'error' => $e->getMessage(),
                        'success' => false
                    ], 400);
                }

            }else {
                return response()->json([
                    'message' => 'Sorry new password can not be the old password!',
                    'success' => false
                ], 401);
            }
        }else {
            return response()->json([
                'message' => 'Sorry old password doesnt matched',
                'success' => false
            ], 402);
        }
    }

    /**
     * get all hospitals
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllHospitalAction(): JsonResponse|AnonymousResourceCollection
    {
        $hospitals = $this->model->where('role', '=', RolesEnum::HOSPITAL)->latest()->paginate(10);
        if (count($hospitals) < 1) {
            return response()->json([
                'message' => 'Sorry no hospital found',
                'success' => false
            ], 404);
        }else {
            return UserResource::collection($hospitals)->additional([
                'message' => "All hospitals",
                'success' => true
            ], 200);
        }
    }

    /**
     * get account details
     * @param $id
     * @return UserResource
     */
    public function getAccountAction($id): UserResource
    {
        $account = $this->model->findOrFail($id);
        return (new UserResource($account))->additional( [
            'message' => "Account details",
            'success' => true
        ], 200);
    }

    /**
     * update agent account
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateAgentAccountAction($request, $id): JsonResponse
    {
        $account =  $this->model->findOrFail($id);
        try {
            $update = $account->agent()->update([
                'name' => empty($request->name) ? $account->name : $request->name,
                'address' => empty($request->address) ? $account->address : $request->address,
                'lga_id' => empty($request->lga_id) ? $account->lga_id : $request->lga_id,
                'phone_number' => empty($request->phone_number) ? $account->phone_number : $request->phone_number
            ]);
            return response()->json([
                'message' => 'Account updated successfully',
                'data' => new UserResource($account),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to update account',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * update hospital account
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function updateHospitalAccountAction($request, $id): JsonResponse
    {
        $account =  $this->model->findOrFail($id);
        try {
            $update = $account->hospital()->update([
                'name' => empty($request->name) ? $account->name : $request->name,
                'address' => empty($request->address) ? $account->address : $request->address,
                'lga_id' => empty($request->lga_id) ? $account->lga_id : $request->lga_id,
                'phone_number' => empty($request->phone_number) ? $account->phone_number : $request->phone_number
            ]);
            return response()->json([
                'message' => 'Account updated successfully',
                'data' => new UserResource($account),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to update account',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

    /**
     * delete category
     * @param $id
     * @return JsonResponse
     */
    public function deleteAccountActon($id): JsonResponse
    {
        $user =  $this->model->findOrFail($id);
        try {
            $user->delete();
            return response()->json([
                'message' => 'Account deleted successfully',
                'data' => new UserResource($user),
                'success' => true
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Sorry unable to delete account',
                'error' => $e->getMessage(),
                'success' => false
            ], 400);
        }
    }

}
