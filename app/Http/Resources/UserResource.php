<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $phone_number
 * @property mixed $address
 * @property mixed $status
 * @property mixed $email_verified_at
 * @property mixed $lga
 * @property mixed $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $role
 * @property mixed $agent
 * @property mixed $hospital
 * @property mixed $enrollee
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $helper = new SystemHelper();
        $arrayData = [
            'id' => $this->id,
            'email' => $helper->cleanStringHelper($this->email),
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->role,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        if ($this->role === 'agent'){
            $arrayData['details'] = new AgentResource($this->agent);
        } else if($this->role === 'hospital') {
            $arrayData['details'] = new HospitalResource($this->hospital);
        }elseif($this->role === 'user') {
            $arrayData['details'] = new EnrolleResource($this->enrollee);
        }
        return  $arrayData;
    }
}
