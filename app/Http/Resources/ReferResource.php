<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $case
 * @property mixed $hospital_name
 * @property mixed $remark
 * @property mixed $slug
 * @property mixed $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ReferResource extends JsonResource
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
            'case' => $helper->cleanStringHelper($this->case),
            'hospital_name' => $helper->cleanStringHelper($this->hospital_name),
            'remark' => $helper->cleanStringHelper($this->remark),
            'slug' => $helper->cleanStringHelper($this->slug),
            'relationships' => [
                'enrolle' => new EnrolleResource($this->whenLoaded('enrolle')),
                'hospital' => new HospitalResource($this->whenLoaded('hospital'))
            ],
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
