<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimResource extends JsonResource
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
            'date_of_admission' => $this->date_of_admission, 
            'date_of_discharge' => $this->date_of_discharge,
            'treatment_details' => $helper->cleanStringHelper($this->treatment_details), 
            'diagnosis' => $helper->cleanStringHelper($this->diagnosis), 
            'investigations' => $helper->cleanStringHelper($this->investigations), 
            'cost' => $helper->cleanStringHelper($this->cost), 
            'payment_status'  => $helper->cleanStringHelper($this->payment_status),
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
