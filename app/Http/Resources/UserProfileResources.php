<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResources extends JsonResource
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
            "followersCount" => $this->followers->count(),
            "followingsCount" => $this->followings->count(),
            "adsCount" => $this->countAds->count(),
            // "followers" => $this->followers,
            "ads" => AdResources::collection($this->ads)
        ];
    }
}
