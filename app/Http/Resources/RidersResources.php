<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RidersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "fullname" => $this->fullname,
            "numPlate" => $this->numPlate
        ];
    }
}
