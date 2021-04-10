<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $newReview = new reviews();
        $newReview->user_id = $request->input("user_id");
        $newReview->ad_id = $request->input("ad_id");
        $newReview->review = $request->input("review");
        $newReview->datePosted = $request->input("date");
        if ($newReview->save()) {
            return response()->json(["response" => "successful", "review" => $newReview]);
        }
    }
}
