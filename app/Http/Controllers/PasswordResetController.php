<?php

namespace App\Http\Controllers;

use App\Models\passwordReset;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function sendSMS($number, $message)
    {
        $private_key = '2021050498000902';
        $public_key = '085b9a34f27d6ec1';
        $sender = 'FarmerTrust';
        $message = rawurlencode($message);
        $url = 'http://api.msmpusher.net/v1/send';
        $data = [
            "privatekey" => $private_key,
            "publickey" => $public_key,
            "sender" => $sender,
            "numbers" => $number,
            "message" => $message
        ];
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json"
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function sendCode(Request $request)
    {

        //date('Y-m-d H:i:s')
        $reset = new passwordReset();
        $number = $request->input("number");
        $message = $request->input("message");
        $reset->user_id = $request->input("user_id");
        $reset->code = $request->input("code");
        $reset->date = date("Y-m-d H:i:s");
        if (!$reset::where("user_id", $reset->user_id)->first()) {
            if ($reset->save()) {
                return response()->json(["message" => "successfull", "sms" => json_decode($this->sendSMS($number, $message))]);
            }
        } else {
            return ($this->resendCode($reset->user_id, $reset->code));
        }
    }

    public function verifyCode($id)
    {
        $code = passwordReset::where("user_id", $id)->first();
        $now = date("Y-m-d H:i:s");
        $date = $code->date;
        $time =   strtotime($now) - strtotime($date);
        if ($time > 240) {
            return response()->json(['message' => "expired", "data" => $code]);
        } else {
            return response()->json(['message' => "active", "data" => $code]);
        }
    }

    public function resendCode($id, $newCode)
    {
        $code = passwordReset::where("user_id", $id)->first();
        $date = date("Y-m-d H:i:s");
        $code->date = $date;
        $code->code = $newCode;
        if ($code->save()) {
            return response()->json(['message' => "successful", "data" => $code]);
        }
    }
}
