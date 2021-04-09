<?php

namespace App\Http\Controllers;

use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function GuzzleHttp\Psr7\hash;
use PHPUnit\Framework\Constraint\Exception;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $user = User::select('*')->where('email', $request->input('email'))->first();
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
            } else {
                throw Exception();
            }
        }
    }

    public function login(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");
        $user = User::select("*")->where("email", $email)->first();
        if ($user) {
            if (Hash::check($password, $user->user_password)) {
                return response()->json(["response" => "successful", "user" => $user]);
            } else {
                return response()->json(["response" => "wrong credentials", "user" => $user]);
            }
        } else {
            return response()->json(["response" => "wrong credentials", "user" => $user]);
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
            } else {
                throw Exception();
            }
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
                return response()->json(["response" => "successful", "user" => $user]);
            }
        } else {
            return response()->json(["response" => "user not found", "user" => $user]);
        }
    }

    public function getAll()
    {

        return User::all();
    }
}
