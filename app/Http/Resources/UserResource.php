<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "email" => $this->email,
            "phone" => $this->phone,
            "image" => $this->image,
            "verified" => $this->verified,
            "followersCount" => $this->followers->count(),
            "followingsCount" => $this->followings->count(),

        ];
    }
}
