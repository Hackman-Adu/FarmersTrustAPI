<?php

namespace App\Http\Controllers;


use App\Models\Ads;
use Illuminate\Http\Request;
use App\Http\Resources\AdResources;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdsController extends Controller
{
    //getting all ads from users
    public function all()
    {
        try {
            $ads = Ads::where('approved', '0')->orderBy("id", "DESC")->paginate(20);
            return AdResources::collection($ads);
        } catch (\Throwable $th) {
            Log::error("getting ads", [$th]);
        }
    }
    public function getByCategory($category, $sort)
    {
        $sortBy = "";
        $from = "";
        switch ($sort) {
            case 'old':
                $sortBy = "id";
                $from = "ASC";
                break;
            case 'low':
                $sortBy = "price";
                $from = "ASC";
                break;
            case 'high':
                $sortBy = "price";
                $from = "DESC";
                break;
            default:
                $sortBy = "id";
                $from = "DESC";
                break;
        }
        $categories = ["productCategory" => $category];
        $ads = Ads::where($categories)->orderBy($sortBy, $from)->paginate(20);
        return AdResources::collection($ads);
    }
    public function searchProducts($value, $category, $sort)
    {
        $sortBy = "";
        $from = "";
        switch ($sort) {
            case 'old':
                $sortBy = "id";
                $from = "ASC";
                break;
            case 'low':
                $sortBy = "price";
                $from = "ASC";
                break;
            case 'high':
                $sortBy = "price";
                $from = "DESC";
                break;
            default:
                $sortBy = "id";
                $from = "DESC";
                break;
        }
        $ads = null;
        if ($category == "All") {
            $ads = Ads::where("productName", "like", '%' . $value . '%')->orderBy($sortBy, $from)->paginate(20);
        } else {
            $ads = Ads::where("productName", "like", '%' . $value . '%')->where("productCategory", "=", $category)->orderBy($sortBy, $from)->paginate(20);
        }
        return AdResources::collection($ads);
    }
    public function getRelatedProducts($category, $id)
    {
        $ads = Ads::where("productCategory", $category)->where("id", "<>", $id)->orderBy("id", "DESC")->paginate(20);
        return AdResources::collection($ads);
    }
    //getting ads from a particular user
    public function view($id)
    {
        $ads = Ads::where("user_id", "=", $id)->orderBy("id", "DESC")->paginate(20);
        return AdResources::collection($ads);
    }

    // getting a particular ad from a particular user for refreshing ad status
    public function refreshAd($id)
    {
        $ad = Ads::find($id);
        return response()->json(["response" => "successful", "ad" => new AdResources($ad)]);
    }

    //creating new user ad
    public function create(Request $request)
    {
        try {
            $ads = Ads::create($request->all());
            if ($ads) {
                return response()->json(['response' => "successful", "ad" => new AdResources($ads)]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('an error occurred in creating ads', [$th]);
        }
    }
    //updating a particular ad item
    public function update(Request $request, $id)
    {
        $ad = Ads::find($id);
        $inputs = $request->all();
        if ($ad->fill($inputs)->save()) {
            return "updated";
        };
    }
    //deleting a particular ad item
    public function delete($id)
    {
        $ad = Ads::find($id);
        if ($ad->delete()) {
            return "item deleted";
        }
    }
}
