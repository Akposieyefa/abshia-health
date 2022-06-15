<?php

namespace App\Http\Resources;

use App\Libs\Helpers\SystemHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ServiceResource extends JsonResource
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
            'description' => $helper->cleanStringHelper($this->description),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
