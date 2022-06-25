<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $market_reality
 * @property mixed $importance
 * @property mixed $solution_platform
 * @property mixed $key_things
 * @property mixed $ideal_relationship
 * @property mixed $facility_band
 * @property mixed $patient_percentage
 * @property mixed $second_third_investigation
 * @property mixed $perceive_hmo
 * @property mixed $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $name
 */
class FeedbackResource extends JsonResource
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
            'name' => $helper->cleanStringHelper($this->name),
            'market_reality'  => $helper->cleanStringHelper($this->market_reality),
            'importance'  => $helper->cleanStringHelper($this->importance),
            'solution_platform'  => $helper->cleanStringHelper($this->solution_platform),
            'key_things'  => $helper->cleanStringHelper($this->key_things),
            'ideal_relationship'  => $helper->cleanStringHelper($this->ideal_relationship),
            'facility_band'  => $helper->cleanStringHelper($this->facility_band),
            'patient_percentage'  => $helper->cleanStringHelper($this->patient_percentage),
            'second_third_investigation'  => $helper->cleanStringHelper($this->second_third_investigation),
            'perceive_hmo'  => $helper->cleanStringHelper($this->perceive_hmo),
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
