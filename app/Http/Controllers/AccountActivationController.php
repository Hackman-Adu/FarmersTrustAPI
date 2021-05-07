<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SMSController;
use App\Models\account_activation;
use Illuminate\Http\Request;

class AccountActivationController extends Controller
{
    public function sendActivationCode(Request $request)
    {
        $activation = new account_activation();
        $message = $request->input("message");
        $activation->phone = $request->input("phone");
        $activation->code = $request->input("code");
        $activation->date = date("Y-m-d H:i:s");
        if (!$activation::where("phone", $activation->phone)->first()) {
            if ($activation->save()) {
                return response()->json(["message" => "successful", "sms" => json_decode(SMSController::sendSMS($activation->phone, $message))]);
            } else {
                return response()->json(["message" => "failed", "sms" => json_decode(SMSController::sendSMS($activation->phone, $message))]);
            }
        } else {
            return ($this->resendCode($activation->phone, $activation->code, $message));
        }
    }
    public function verifyCode($phone, $activationCode)
    {
        $code = account_activation::where("phone", $phone)->where("code", $activationCode)->first();
        if ($code) {
            $today = date("Y-m-d H:i:s");
            $date = $code->date;
            $time =   strtotime($today) - strtotime($date);
            if ($time > 86400) {
                //expired
                return "100";
            } else {
                //active.....update user account later
                return "111";
            }
        } else {
            //does not exist
            return "000";
        }
    }
    public function resendCode($phone, $newCode, $message)
    {
        $code = account_activation::where("phone", $phone)->first();
        $date = date("Y-m-d H:i:s");
        $code->date = $date;
        $code->code = $newCode;
        if ($code->save()) {
            return response()->json(['message' => "successful", "sms" => json_decode(SMSController::sendSMS($phone, $message))]);
        } else {
            return response()->json(['message' => "failed", "sms" => json_decode(SMSController::sendSMS($phone, $message))]);
        }
    }
}
