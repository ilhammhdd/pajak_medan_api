<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/1/2018
 * Time: 3:07 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketGoodsController extends Controller
{
    public function getBasketGoods(Request $request)
    {
        $this->validate(
            $request,
            [
                'data.basket_id' => 'required|exists:baskets,id'
            ]
        );

        $basketGoods = DB::select(
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
                LEFT JOIN files ON goods.file_id = files.id
                LEFT JOIN status ON baskets.status_id = status.id 
                WHERE baskets_goods.basket_id = :basket_id',
            [
                'basket_id' => $request->json("data")["basket_id"]
            ]
        );

        return $this->jsonResponse([
            'basket_id' => $request->json("data")["basket_id"],
            'basket_goods' => $basketGoods,
        ], true, 'berhasil mendapatkan semua goods didalam basket');
    }

    public function getGoodInBasket(Request $request)
    {
        $this->validate(
            $request,
            [
                'data.good_id' => 'required|exists:goods,id'
            ]
        );

        $goodInBasket = DB::select(
            'SELECT
            baskets_goods.good_quantity
            FROM baskets_goods
            JOIN baskets ON baskets_goods.basket_id = baskets.id
            WHERE baskets_goods.good_id = :good_id
            AND baskets.id = :basket_id',
            [
                'good_id' => $request->json("data")["good_id"],
                'basket_id' => $request->get('basket')->id
            ]
        );

        if ($goodInBasket == []) {
            return $this->jsonResponse([
                'good_in_basket' => 0
            ], false, 'goods tidak ditemukan di basket user');
        }

        return $this->jsonResponse([
            'good_in_basket' => $goodInBasket[0]->good_quantity
        ], true, 'goods ini ada di basket user');
    }
}