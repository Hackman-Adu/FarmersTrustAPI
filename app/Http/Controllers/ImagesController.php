<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;

class ImagesController extends Controller
{
    public function create(Request $request)
    {
        $image = new Images();
        $image->user_id = $request->input("user_id");
        $image->ad_id = $request->input("ad_id");
        $image->imageUrl = $request->input("imageUrl");
        if ($image->save()) {
            return response()->json(['response' => "successful", "images" => $image]);
        }
    }
}
