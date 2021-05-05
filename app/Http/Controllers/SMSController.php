<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSController extends Controller
{
    public static function sendSMS($number, $message)
    {
        $private_key = '2021050498000902';
        $public_key = '085b9a34f27d6ec1';
        $sender = 'Farmer Trust';
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
}
