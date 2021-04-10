<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResources extends JsonResource
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
            "productCategory" => $this->productCategory,
            "productName" => $this->productName,
            "price" => $this->price,
            "location" => $this->location,
            "description" => $this->description,
            "negotiable" => $this->negotiable,
            "datePosted" => $this->datePosted,
            "approved" => $this->approved,
            "user" => $this->user,
            "images" => $this->images,
            "reviews" => ReviewResource::collection($this->reviews)
        ];
    }
}
