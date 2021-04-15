<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Followers;
use App\Http\Resources\FollowersResource;
use App\Http\Resources\UserResource;

class FollowersController extends Controller
{
    public function followings($userID)
    {
        $followings = User::find($userID);
        return UserResource::collection($followings->followings);
    }
    public function followers($userID)
    {
        $followings = User::find($userID);
        return UserResource::collection($followings->followers);
    }
}
