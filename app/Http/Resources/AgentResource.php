<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $phone_number
 * @property mixed $address
 * @property mixed $slug
 * @property mixed $status
 * @property mixed $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $ref_code
 * @property mixed $enrolled_users
 */
class AgentResource extends JsonResource
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
        return [
            'id' => $this->id,
            'code' => $helper->cleanStringHelper($this->ref_code),
            'name' => $helper->cleanStringHelper($this->name),
            'phone_number' => $helper->cleanStringHelper($this->phone_number),
            'address' => $helper->cleanStringHelper($this->address),
            'slug' => $helper->cleanStringHelper($this->slug),
            'status' => $this->status,
            'relationships' => [
                'enrolled_users' => EnrolleResource::collection($this->enrolled_users),
            ],
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
