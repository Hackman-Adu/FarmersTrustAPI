<?php

namespace App\Http\Controllers;


use App\Models\Ads;
use Illuminate\Http\Request;
use App\Http\Resources\AdResources;

class AdsController extends Controller
{
    public function all()
    {
        $ads = Ads::all();
        return response()->json(["response" => "successful", "ads" => AdResources::collection($ads)]);
    }

    public function view($id)
    {
        $ads = Ads::all()->where("user_id", "=", $id);
        return response()->json(["response" => "successful", "ads" => AdResources::collection($ads)]);
    }
    public function create(Request $request)
    {
        $ad = new Ads();
        $ad->user_id = $request->input("user_id");
        $ad->productCategory = $request->input("productCategory");
        $ad->productName = $request->input("productName");
        $ad->price = $request->input("price");
        $ad->location = $request->input("location");
        $ad->description = $request->input("description");
        $ad->negotiable = $request->input("negotiable");
        $ad->datePosted = $request->input("datePosted");
        if ($ad->save()) {
            return response()->json(['response' => "successful", "ad" => new AdResources($ad)]);
        }
    }
}
