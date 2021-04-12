<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
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

    public function all($id)
    {
        $reviews = reviews::all()->where("ad_id", "=", $id);
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
