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
        $user = User::where("id", "=", $userID)->first();
        return UserResource::collection($user->followings()->paginate(20));
    }
    public function followers($userID)
    {
        $user = User::where("id", "=", $userID)->first();
        return UserResource::collection($user->followers()->paginate(20));
        // $user = User::find($userID);
        // return response()->json(['response' => "successful", "followers" => UserResource::collection($user->followers)]);
    }
    public function unFollow($userID, $followerID)
    {
        $relation = Followers::where("user_id", "=", $userID)->where("follower_id", "=", $followerID)->delete();
        if ($relation) {
            return "unfollowed";
        }
    }
    public function follow(Request $request)
    {
        $user = new Followers();
        $user->user_id = $request->input("user_id");
        $user->follower_id = $request->input("follower_id");
        if ($user->save()) {
            return "followed";
        } else {
            return "failed";
        }
    }
}
