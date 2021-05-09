<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersReceivedResources;
use App\Http\Resources\OrdersResources;
use App\Models\OrderDetails;
use App\Models\orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function newOrder(Request $request)
    {
        $order = new orders();
        $order->buyer_id = $request->input("buyer_id");
        $order->seller_id = $request->input("seller_id");
        $order->ad_id = $request->input("ad_id");
        if ($order->save()) {
            return response()->json(["message" => "successful", "order" => new OrdersResources($order)]);
        }
    }
    public function orderDetails(Request $request)
    {
        $details = new OrderDetails();
        $fields = $request->all();
        $details->fill($fields);
        if ($details->save()) {
            if (orders::where("id", $request->input("order_id"))->update(array("status" => 1))) {
                return response()->json(["message" => "successful", "order" => new OrdersResources(orders::find($request->input("order_id")))]);
            }
        }
    }

    public function PlacedOrders($id)
    {
        $order = orders::where("buyer_id", $id)->where("status", 1)->orderBy("id", "DESC")->get();
        return  response()->json(["message" => "successful", "orders" => OrdersResources::collection($order)]);
    }
    public function receivedOrders($id)
    {
        $order = orders::where("seller_id", $id)->where("status", 1)->orderBy("id", "DESC")->get();
        return response()->json(["message" => "successful", "orders" => OrdersReceivedResources::collection($order)]);
    }
}
