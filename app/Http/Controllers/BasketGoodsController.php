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
                baskets.status AS baskets_status, 
                baskets_goods.good_quantity AS baskets_goods_quantity, 
                baskets_goods.total_price AS baskets_goods_total_price 
                FROM baskets_goods  
                LEFT JOIN goods ON baskets_goods.good_id = goods.id 
                LEFT JOIN baskets ON baskets_goods.basket_id = baskets.id 
                LEFT JOIN files ON goods.file_id = files.id 
                WHERE baskets_goods.basket_id = ' . $request->json("data")["basket_id"]
        );

        return response()->json([
            'success' => true,
            'message' => "Successfully get all the goods in basket",
            'basket_id' => $request->json("data")["basket_id"],
            'basket_goods' => $basketGoods
        ]);
    }
}