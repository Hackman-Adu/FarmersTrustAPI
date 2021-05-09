<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResources extends JsonResource
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
            "buyer_id" => $this->buyer_id,
            "details" => $this->orderdetails,
            "seller" => $this->seller
        ];
    }
}
