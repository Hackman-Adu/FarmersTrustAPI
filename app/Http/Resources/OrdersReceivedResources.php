<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersReceivedResources extends JsonResource
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
            "date" => $this->created_at,
            "status" => $this->status,
            "seller_id" => $this->seller_id,
            "details" => $this->orderdetails,
            "buyer" => new UserResource($this->seller)
        ];
    }
}
