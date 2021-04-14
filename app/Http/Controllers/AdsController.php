<?php

namespace App\Http\Controllers;


use App\Models\Ads;
use Illuminate\Http\Request;
use App\Http\Resources\AdResources;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            Log::info('ads requests', [$request->all()]);
            $ads = Ads::create($request->all());
            if ($ads) {
                return response()->json(['response' => "successful", "ad" => new AdResources($ads)]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('an error occurred in creating ads', [$th]);
        }
    }
    public function update(Request $request, $id)
    {
        $ad = Ads::find($id);
        $inputs = $request->all();
        if ($ad->fill($inputs)->save()) {
            return "updated";
        };
    }
    public function delete($id)
    {
        $ad = Ads::find($id);
        if ($ad->delete()) {
            return "item deleted";
        }
    }
}
