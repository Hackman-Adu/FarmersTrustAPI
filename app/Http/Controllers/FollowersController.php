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
        $user = User::find($userID);
        return response()->json(['response' => "successful", "followings" => UserResource::collection($user->followings)]);
    }
    public function followers($userID)
    {
        $user = User::find($userID);
        return response()->json(['response' => "successful", "followers" => UserResource::collection($user->followers)]);
    }
    public function unFollow($userID, $followerID)
    {
        $relation = Followers::where("user_id", "=", $userID)->where("follower_id", "=", $followerID)->delete();
        if ($relation) {
            return "unfollowed";
        }
    }
}
