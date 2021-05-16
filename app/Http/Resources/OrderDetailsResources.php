<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResources extends JsonResource
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
            "order_id" => $this->order_id,
            "orderNumber" => $this->orderNumber,
            "product" => $this->product,
            "total_price" => $this->total_price,
            "quantity" => $this->quantity,
            "orderType" => $this->orderType,
            "location" => $this->location,
            "phone" => $this->phone,
            "rider" => $this->rider,
        ];
    }
}
