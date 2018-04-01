<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/30/2018
 * Time: 1:07 AM
 */

namespace App\Http\Controllers;

use App\Basket;
use App\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function issueCheckout(Request $request)
    {
        $checkout = new Checkout();
        $checkout->payment_id = $request->json("data")["payment_id"];
        $checkout->basket_id = $request->json("data")["basket_id"];
        $checkout->status_id = $request->json("data")["status_id"];
        $checkout->expired = $request->json("data")["expired"];
        $checkout->save();

        $basket = Basket::find($request->json("data")["basket_id"])->first();
        $basket->status_id = 5;
        $basket->save();
    }

    public function getIssuedCheckout(Request $request)
    {
        $allCheckout = Basket::find($request->json("data")["customer_id"])->checkout()->get();

        return response()->json([
            "success" => true,
            "response_data" => [
                "all_checkout" => $allCheckout,
                "message" => "Successfully get all checkouts"
            ]
        ]);
    }
}