<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\passwordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordResetController extends Controller
{
    public function sendCode(Request $request)
    {
        $reset = new passwordReset();
        $message = $request->input("message");
        $reset->phone = $request->input("phone");
        $reset->code = $request->input("code");
        $reset->date = date("Y-m-d H:i:s");
        if (!$reset::where("phone", $reset->phone)->first()) {
            if ($reset->save()) {
                return response()->json(["message" => "successful", "sms" => json_decode(SMSController::sendSMS($reset->phone, $message))]);
            } else {
                return response()->json(["message" => "failed", "sms" => json_decode(SMSController::sendSMS($reset->phone, $message))]);
            }
        } else {
            return ($this->resendCode($reset->phone, $reset->code, $message));
        }
    }

    public function checkAccount($phone, $emailAddress)
    {
        $user = User::where("phone", $phone)->where("email", $emailAddress)->first();
        if ($user) {
            return "1";
        } else {
            return "0";
        }
    }

    //verifying user's password reset code
    public function verifyCode($phone, $resetCode)
    {
        $code = passwordReset::where("phone", $phone)->where("code", $resetCode)->first();
        if ($code) {
            $today = date("Y-m-d H:i:s");
            $resetCodeDate = $code->date;
            $time =   strtotime($today) - strtotime($resetCodeDate);
            if ($time > 300) {
                //expired
                return "100";
            } else {
                //active
                return "111";
            }
        } else {
            //does not exist
            return "000";
        }
    }
    public function resendCode($phone, $newCode, $message)
    {
        $code = passwordReset::where("phone", $phone)->first();
        $date = date("Y-m-d H:i:s");
        $code->date = $date;
        $code->code = $newCode;
        if ($code->save()) {
            return response()->json(['message' => "successful", "sms" => json_decode(SMSController::sendSMS($phone, $message))]);
        } else {
            return response()->json(['message' => "failed", "sms" => json_decode(SMSController::sendSMS($phone, $message))]);
        }
    }
    public function newPassword($phone, $password)
    {
        try {
            $user = User::where("phone", $phone)->first();
            $user->user_password = Hash::make($password);
            if ($user->save()) {
                return "successful";
            } else {
                return "failed";
            }
        } catch (\Throwable $th) {
            Log::error("saving password", [$th]);
        }
    }
}
