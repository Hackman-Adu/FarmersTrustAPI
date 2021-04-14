<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\carts;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function view($id)
    {

        $cartItems = carts::where("user_id", "=", $id)->orderBy("id", "DESC")->get();
        return response()->json(["response" => "successful", "items" => CartResource::collection($cartItems)]);
    }
    public function create(Request $request)
    {
        $cart = new carts();
        $cart->user_id = $request->input("user_id");
        $cart->ad_id = $request->input("ad_id");
        if ($cart->save()) {
            return response()->json(['response' => "successful", "item" => new CartResource($cart)]);
        }
    }
    public function delete($id)
    {
        $cart = carts::find($id);
        if ($cart->delete()) {
            return "item deleted";
        }
    }
    public function deleteAll($userID)
    {
        try {
            $carts = carts::where("user_id", "=", $userID)->delete();
            if ($carts) {
                return "items deleted";
            }
        } catch (\Throwable $th) {
            Log::error("error occurred in deleting all cart items", [$th]);
        }
    }
    public function all()
    {
        $carts = carts::all();
        return CartResource::collection($carts);
    }
}
