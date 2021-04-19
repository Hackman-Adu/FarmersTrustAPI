<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $review = reviews::where("user_id", $request->input("user_id"))->where("ad_id", $request->input("ad_id"))->first();
        if ($review) {
            return response()->json(["response" => "not allow", "review" => new ReviewResource($review)]);
        } else {
            $newReview = new reviews();
            $newReview->user_id = $request->input("user_id");
            $newReview->num_stars = $request->input("num_stars");
            $newReview->ad_id = $request->input("ad_id");
            $newReview->review = $request->input("review");
            $newReview->datePosted = $request->input("date");
            if ($newReview->save()) {
                return response()->json(["response" => "successful", "review" => new ReviewResource($newReview)]);
            }
        }
    }
    public function all($id)
    {
        $reviews = reviews::where("ad_id", "=", $id)->orderBy("id", "DESC")->paginate(5);
        return  ReviewResource::collection($reviews);
    }
    public function reviews()
    {
        $reviews = reviews::all();
        return response()->json(["response" => "successful", "reviews" => ReviewResource::collection($reviews)]);
    }

    public function delete($id)
    {
        $review = reviews::find($id);
        if ($review->delete()) {
            return "review deleted";
        }
    }
}
