<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $duration
 * @property mixed $cost
 * @property mixed $slug
 * @property mixed $properties
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $deleted_at
 */
class PlanResource extends JsonResource
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
            'id'   => $this->id,
            'title'  => $helper->cleanStringHelper($this->title),
            'description'   => $helper->cleanStringHelper($this->description),
            'duration'    => $helper->cleanStringHelper($this->duration),
            'cost'  => $helper->cleanStringHelper($helper->convertKoboToNaira($this->cost)),
            'slug'      => $helper->cleanStringHelper($this->slug),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
