<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 * @property mixed $id
 * @property mixed $verified_by
 * @property mixed $date_and_time
 * @property mixed $is_capitated
 * @property mixed $is_ffs
 * @property mixed $drugs
 * @property mixed $cost_of_treatment
 * @property mixed $height
 * @property mixed $weight
 * @property mixed $blood_pressure
 * @property mixed $pulse
 * @property mixed $respiration
 * @property mixed $temperature
 * @property mixed $treatment_give
 * @property mixed $is_referred
 * @property mixed $summary
 */
class TreatmentResource extends JsonResource
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
            'verified_by' =>  $helper->cleanStringHelper($this->verified_by),
            'date_and_time'  =>  $this->date_and_time,
            'is_capitated'  =>  $this->is_capitated,
            'is_ffs'  =>  $helper->cleanStringHelper($this->is_ffs),
            'drugs'  =>  $helper->cleanStringHelper($this->drugs),
            'cost_of_treatment'  =>  $helper->cleanStringHelper($this->cost_of_treatment),
            'height'  =>  $helper->cleanStringHelper($this->height),
            'weight'  =>  $helper->cleanStringHelper($this->weight),
            'blood_pressure'  =>  $helper->cleanStringHelper($this->blood_pressure),
            'pulse'  =>  $helper->cleanStringHelper($this->pulse),
            'respiration'  =>  $helper->cleanStringHelper($this->respiration),
            'temperature'  =>  $helper->cleanStringHelper($this->temperature),
            'treatment_give'  =>  $helper->cleanStringHelper($this->treatment_give),
            'is_referred' => $this->is_referred,
            'summary' => $this->summary,
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
