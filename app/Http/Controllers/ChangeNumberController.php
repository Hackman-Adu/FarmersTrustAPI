<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChangeNumberController extends Controller
{
    public function changeNumber($id, $phone)
    {
        $user = User::where("phone", $phone)->first();
        if ($user) {

            //number already exists
            return "1";
        } else {
            if (User::where("id", $id)->update(array("phone" => $phone))) {
                return "successful";
            }
        }
    }
}
