<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exception;
use App\Http\Resources\UserResource;
use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function GuzzleHttp\Psr7\hash;
use App\Http\Resources\UserProfileResources;

class UserController extends Controller
{

    public function create(Request $request)
    {
        try {
            $user = User::select('*')->where('email', $request->input('email'))->orWhere("phone", $request->input("phone"))->first();
            if ($user) {
                return response()->json(['response' => "account exists", "user" => $user]);
            } else {
                $user = new User();
                $user->fullname = $request->input("fullname");
                $user->email = $request->input("email");
                $user->phone = $request->input("phone");
                $user->user_password = Hash::make($request->input("password"));
                $user->image = $request->input("image");
                if ($user->save()) {
                    return response()->json(['response' => "successful", "user" => $user]);
                } else { }
            }
        } catch (\Throwable $th) {
            Log::error("creating account", [$th]);
        }
    }

    public function login(Request $request)
    {
        try {
            $email = $request->input("email");
            $password = $request->input("password");
            $user = User::select("*")->where("email", $email)->orWhere("phone", $email)->first();
            if ($user) {
                if (Hash::check($password, $user->user_password)) {
                    return response()->json(["response" => "successful", "user" => new UserResource($user)]);
                } else {
                    return response()->json(["response" => "wrong credentials", "user" =>  new UserResource($user)]);
                }
            } else {
                return response()->json(["response" => "wrong credentials", "user" => null]);
            }
        } catch (\Throwable $th) {
            Log::error("Failed to login", [$th]);
        }
    }

    public function reset($id, $old_password, $new_password)
    {
        $user = User::find($id);
        $password = $old_password;
        $newPassword = $new_password;
        if (Hash::check($password, $user->user_password)) {
            $user->user_password = Hash::make($newPassword);
            if ($user->save()) {
                return response()->json(["response" => "successful", "user" => $user]);
            } else { }
        } else {
            return response()->json(["response" => "incorrect password", "user" => null],);
        }
    }

    public function editProfile($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            $user->fullname = $request->input("fullname");
            $user->phone = $request->input("phone");
            $user->image = $request->input("image");

            if ($user->save()) {
                return response()->json(["response" => "successful", "user" => new UserResource($user)]);
            }
        } else {
            return response()->json(["response" => "user not found", "user" => null]);
        }
    }

    public function getAll()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function viewProfile($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                return response()->json(['response' => "successful", "data" => new UserProfileResources($user)]);
            } else {
                return response()->json(['response' => "user not found", "data" => null]);
            }
        } catch (\Throwable $th) {
            Log::error("creating account", [$th]);
        }
    }

    public function view($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                return response()->json(['response' => "successful", "user" => new UserResource($user)]);
            } else {
                return response()->json(['response' => "user not found", "user" => null]);
            }
        } catch (\Throwable $th) {
            Log::error("creating account", [$th]);
        }
    }
}
