<?php

namespace App\Http\Controllers;


use App\Models\Ads;
use Illuminate\Http\Request;
use App\Http\Resources\AdResources;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function all()
    {
        $ads = Ads::where('approved', '0')->orderBy("id", "DESC")->get();
        return response()->json(["response" => "successful", "ads" => AdResources::collection($ads)]);
    }

    public function view($id)
    {
        $ads = Ads::where("user_id", "=", $id)->orderBy("id", "DESC")->get();
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
    public function delete($id)
    {
        $ad = Ads::find($id);
        if ($ad->delete()) {
            return "item deleted";
        }
    }
}
