<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $first_name
 * @property mixed $middle_name
 * @property mixed $gender
 * @property mixed $phone_number
 * @property mixed $dob
 * @property mixed $address
 * @property mixed $blood_group
 * @property mixed $town
 * @property mixed $nok_name
 * @property mixed $nok_address
 * @property mixed $nok_phone
 * @property mixed $nok_relationship
 * @property mixed $mda_school_name
 * @property mixed $genotype
 * @property mixed $marital_status
 * @property mixed $no_of_dependants
 * @property mixed $existing_medical_condition
 * @property mixed $hypertension
 * @property mixed $sickle_cell
 * @property mixed $cancer
 * @property mixed $kidney_issue
 * @property mixed $slug
 * @property mixed $deleted_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $state
 * @property mixed $lga
 * @property mixed $primaryHealthCare
 * @property mixed $agent
 * @property mixed $surname
 * @property mixed $emp_id
 */
class EnrolleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {$helper = new SystemHelper();
        return [
            'id' => $this->id,
            'emp_id' => $helper->cleanStringHelper($this->emp_id),
            'title' => $helper->cleanStringHelper($this->title),
            'surname' => $helper->cleanStringHelper($this->surname),
            'first_name' => $helper->cleanStringHelper($this->first_name),
            'middle_name' => $helper->cleanStringHelper($this->middle_name),
            'gender' => $helper->cleanStringHelper($this->gender),
            'phone_number' => $helper->cleanStringHelper($this->phone_number),
            'dob' => $this->dob,
            'address' => $helper->cleanStringHelper($this->address),
            'blood_group' => $helper->cleanStringHelper($this->blood_group),
            'town' => $helper->cleanStringHelper($this->town),
            'nok_name' => $helper->cleanStringHelper($this->nok_name),
            'nok_address' => $helper->cleanStringHelper($this->nok_address),
            'nok_phone' => $helper->cleanStringHelper($this->nok_phone),
            'nok_relationship' => $helper->cleanStringHelper($this->nok_relationship),
            'mda_school_name' => $helper->cleanStringHelper($this->mda_school_name),
            'genotype' => $helper->cleanStringHelper($this->genotype),
            'marital_status' => $helper->cleanStringHelper($this->marital_status),
            'no_of_dependants' => $helper->cleanStringHelper($this->no_of_dependants),
            'existing_medical_condition' => $this->existing_medical_condition,
            'hypertension' => $this->hypertension,
            'sickle_cell' => $this->sickle_cell,
            'cancer' => $this->cancer,
            'kidney_issue' => $this->kidney_issue,
            'slug' => $this->slug,
            'relationships' => [
                'state' => $this->state->state_name,
                'lga' => $this->lga->lga_name,
                'primary_healthcare' => $this->primaryHealthCare->name,
                'agents' => is_null($this->agent) ? ""  :  $this->agent->name
            ],
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
