<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $appointment_reason
 * @property mixed $status
 * @property mixed $approved_date
 * @property mixed $approved_comment
 * @property mixed $slug
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 * @property mixed $appointment_date
 */
class AppointmentResource extends JsonResource
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
            'title' => $helper->cleanStringHelper($this->title),
            'appointment_reason' => $helper->cleanStringHelper($this->appointment_reason),
            'appointment_date' => $this->appointment_date,
            'status' => $this->status,
            'approved_date' => $this->approved_date,
            'approval_comment' => $this->approved_comment,
            'slug' => $this->slug,
            'relationships' => [
                'enrolle' => new EnrolleResource($this->whenLoaded('enrolle')),
                'hospital' => new HospitalResource($this->whenLoaded('hospital'))
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
