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
        $this->validate(
            $request,
            [
                'payment_id' => 'required|exists:payments,id',
                'expired' => 'required|date_format:Y-m-d H:i:s',
                'issued' => 'required|date_format:Y-m-d H:i:s'
            ]
        );

        $basket = Basket::find($request->get('basket')->id);
        $basket->status_id = 5;
        $saveBasketSuccess = $basket->save();

        $checkout = new Checkout();
        $checkout->payment_id = $request->json('payment_id');
        $checkout->basket_id = $request->get('basket')->id;
        $checkout->status_id = 2;
        $checkout->expired = $request->json('expired');
        $checkout->issued = $request->json('issued');
        $saveCheckoutSuccess = $checkout->save();

        if ($saveBasketSuccess && $saveCheckoutSuccess) {
            return $this->jsonResponse(null, true, "Successfully issued the checkout.");
        }
        return $this->jsonResponse(null, false, "Failed to issue the checkout.", 500);
    }

    public function getIssuedCheckout(Request $request)
    {
        event(new CheckoutExpiredEvent($request->get('customer')->id));

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
            [
                'customer_id' => $request->get('customer')->id
            ]
        );

        if (count($orders) != 0) {
            return $this->jsonResponse([
                'orders' => $orders
            ], true, 'Successfully get all checkouts');
        }

        return $this->jsonResponse(null, false, 'There is no checkout for this user', 404);
    }

    public function getBasketGoods(Request $request)
    {
        $this->validate(
            $request,
            [
                'checkout_id' => 'required|exists:checkouts,id'
            ]
        );

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
                WHERE checkouts.id = ' . $request->get('checkout_id')
        );


        return $this->jsonResponse([
            'checkout_basket_goods' => $checkoutBasketGoods
        ], true, "Successfully get the goods in the basket of this checkout");
    }

    public function getPaymentExpired(Request $request)
    {
        $this->validate(
            $request,
            [
                'checkout_id' => 'required|exists:checkouts,id'
            ]
        );

        $checkout = Checkout::find($request->json('checkout_id'));

        if ($checkout->status_id == 2) {
            return $this->jsonResponse([
                'expired_time' => $checkout->expired
            ], true, 'Successfully get the expired time of the given checkout');
        }

        return $this->jsonResponse(null, false, 'The checkout is failed or expired', 404);
    }
}