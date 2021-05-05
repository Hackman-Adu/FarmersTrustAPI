<?php

namespace App\Http\Controllers;

use App\Models\passwordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\SMSController;

class PasswordResetController extends Controller
{
    public function sendCode(Request $request)
    {
        $reset = new passwordReset();
        $number = $request->input("number");
        $message = $request->input("message");
        $reset->user_id = $request->input("user_id");
        $reset->code = $request->input("code");
        $reset->date = date("Y-m-d H:i:s");
        if (!$reset::where("user_id", $reset->user_id)->first()) {
            if ($reset->save()) {
                return response()->json(["message" => "successful", "sms" => json_decode(SMSController::sendSMS($number, $message))]);
            } else {
                return response()->json(["message" => "failed", "sms" => json_decode(SMSController::sendSMS($number, $message))]);
            }
        } else {
            return ($this->resendCode($reset->user_id, $reset->code, $number, $message));
        }
    }

    //verifying user's password reset code
    public function verifyCode($id, $resetCode)
    {
        $code = passwordReset::where("user_id", $id)->where("code", $resetCode)->first();
        $today = date("Y-m-d H:i:s");
        $resetCodeDate = $code->date;
        $time =   strtotime($today) - strtotime($resetCodeDate);
        if ($time > 1800) {
            return "expired";
        } else {
            return "active";
        }
    }

    public function resendCode($id, $newCode, $number, $message)
    {
        $code = passwordReset::where("user_id", $id)->first();
        $date = date("Y-m-d H:i:s");
        $code->date = $date;
        $code->code = $newCode;
        if ($code->save()) {
            return response()->json(['message' => "successful", "sms" => json_decode(SMSController::sendSMS($number, $message))]);
        } else {
            return response()->json(['message' => "failed", "sms" => json_decode(SMSController::sendSMS($number, $message))]);
        }
    }
}
