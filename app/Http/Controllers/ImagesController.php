<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImagesResource;
use Illuminate\Http\Request;
use App\Models\Images;

class ImagesController extends Controller
{
    public function create(Request $request)
    {
        $image = new Images();
        $image->ad_id = $request->input("ad_id");
        $image->imageUrl = $request->input("imageUrl");
        if ($image->save()) {
            return response()->json(['response' => "successful", "ads" => new ImagesResource($image)]);
        }
    }
}
