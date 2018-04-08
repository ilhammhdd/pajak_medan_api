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
use App\Events\CheckoutExpiredEvent;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function issueCheckout(Request $request)
    {
        $basket = Basket::find($request->get('basket')->id);
        $basket->status_id = 5;
        $saveBasketSuccess = $basket->save();

        $checkout = new Checkout();
        $checkout->payment_id = $request->json("data")["payment_id"];
//        $checkout->basket_id = $request->json("data")["basket_id"];
        $checkout->basket_id = $request->get('basket')->id;
        $checkout->status_id = $request->json("data")["status_id"];
        $checkout->expired = $request->json("data")["expired"];
        $checkout->issued = $request->json("data")["issued"];
        $saveCheckoutSuccess = $checkout->save();

        if ($saveBasketSuccess && $saveCheckoutSuccess) {
            return response()->json([
                "success" => true,
                "message" => "Successfully issued the checkout."
            ]);
        }
        return response()->json([
            "success" => false,
            "message" => "Failed to issue the checkout."]);
    }

    public function getIssuedCheckout(Request $request)
    {
        event(new CheckoutExpiredEvent($request->json("data")["customer_id"]));

        $orders = DB::select(
            'SELECT 
            baskets.total AS total_price,
            baskets.total_items AS total_items,
            checkouts.id AS checkout_id,
            checkouts.issued,
            checkouts.expired,
            status.name AS status
            FROM baskets
            JOIN checkouts ON checkouts.basket_id = baskets.id
            JOIN status ON status.id = checkouts.status_id
            WHERE baskets.customer_id = :customer_id',
            ['customer_id' => $request->json("data")["customer_id"]]
        );

        return response()->json([
            "success" => true,
            "response_data" => [
                "orders" => $orders,
                "message" => "Successfully get all checkouts"
            ]
        ]);
    }

    public function getBasketGoods(Request $request)
    {
        $checkoutBasketGoods = DB::select(
            'SELECT 
                baskets_goods.id AS basket_goods_id, 
                goods.id AS goods_id, 
                files.file_path AS goods_image_url, 
                goods.name AS goods_name, 
                goods.price AS goods_price, 
                goods.unit AS goods_unit, 
                goods.available AS goods_available, 
                goods.min_order AS goods_min_order, 
                goods.condition AS goods_condition, 
                baskets.id AS baskets_id, 
                baskets.customer_id AS baskets_customer_id, 
                baskets.total AS baskets_total, 
                baskets.description AS baskets_description, 
                status.name AS basket_status_name,
                baskets_goods.good_quantity AS baskets_goods_quantity, 
                baskets_goods.total_price AS baskets_goods_total_price 
                FROM baskets_goods  
                LEFT JOIN goods ON baskets_goods.good_id = goods.id 
                LEFT JOIN baskets ON baskets_goods.basket_id = baskets.id 
                LEFT JOIN checkouts ON baskets.id = checkouts.basket_id 
                LEFT JOIN files ON goods.file_id = files.id
                LEFT JOIN status ON baskets.status_id = status.id 
                WHERE checkouts.id = ' . $request->json("data")["checkout_id"]
        );

        return response()->json([
            'success' => true,
            'response_data' => [
                'checkout_basket_goods' => $checkoutBasketGoods,
                'message' => "Successfully get all the goods in basket",
            ]
        ]);
    }

    public function getPaymentExpired(Request $request)
    {
        $checkout = Checkout::find($request->json("data")["checkout_id"]);

        if ($checkout->status_id == 2) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'expired_time' => $checkout->expired,
                    'message' => 'Successfully get the expired time of the given checkout'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'response_data' => [
                'message' => 'The checkout is failed or expired'
            ]
        ]);
    }
}