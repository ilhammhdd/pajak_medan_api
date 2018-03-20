<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/27/2018
 * Time: 4:19 PM
 */

namespace App\Http\Controllers;


use App\Basket;
use App\BasketGoods;
use App\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodController extends Controller
{
    public function getGoods(Request $request)
    {
        $goods = Good::where('category_id', $request->json("data")["category_id"])->get();
        $goodsJsonArray = [];

        foreach ($goods as $good) {
            $goodsJsonArray[] = [
                "id" => $good->id,
                "file_path" => $good->file()->pluck("file_path")->first(),
                "name" => $good->name,
                "price" => $good->price,
                "description" => $good->desciption,
                "available" => $good->available,
                "unit" => $good->unit,
                "min_order" => $good->min_order,
                "condition" => $good->condition
            ];
        }

        return response()->json([
            'success' => true,
            'response_data' => [
                'message' => 'Successfully get all goods of the given category',
                'goods' => $goodsJsonArray
            ]
        ]);
    }

    public function getReview(Request $request)
    {

    }

    public function buyGoods(Request $request)
    {
        $goodInBasket = DB::select(
            'SELECT
            baskets_goods.id, 
            baskets_goods.good_id,
            baskets_goods.basket_id,
            baskets_goods.good_quantity,
            baskets_goods.total_price
            FROM baskets_goods
            JOIN baskets ON baskets_goods.basket_id = baskets.id
            WHERE baskets_goods.good_id = :good_id
            AND baskets.id = :basket_id',
            [
                'good_id' => $request->json("data")["good_id"],
                'basket_id' => $request->get('basket')->id
            ]
        );

        $basket = Basket::find($request->get('basket')->id);

        if ($goodInBasket == []) {
            $newBasketGoods = new BasketGoods();
            $newBasketGoods->good_id = $request->json("data")["good_id"];
            $newBasketGoods->basket_id = $request->get('basket')->id;
            $newBasketGoods->good_quantity = $request->json('data')['good_quantity'];
            $newBasketGoods->total_price = $request->json('data')['good_price'] * $request->json('data')['good_quantity'];
            $newBasketGoods->save();

            $basket->customer_id = $request->json('data')['customer_id'];
            $basket->total = $basket->total + ($request->json('data')['good_quantity'] * $request->json('data')['good_price']);
            $basket->description = "still no description";
            $basket->status_id = 6;
            $basket->save();

            return response()->json([
                'success' => true,
                'response_data' => [
                    'basket_id' => $request->get('basket')->id,
                    'basket_total' => $basket->total,
                    'message' => 'Successfully created a new BasketGoods',
                ]
            ]);
        }

        $basket->customer_id = $request->json('data')['customer_id'];
        $basket->total = $basket->total + ($request->json('data')['good_quantity'] * $request->json('data')['good_price']);
        $basket->description = "still no description";
        $basket->status_id = 6;
        $basket->save();

        $goodsQuantity = $goodInBasket[0]->good_quantity + $request->json('data')['good_quantity'];

        $basketGoods = BasketGoods::find($goodInBasket[0]->id);
        $basketGoods->good_quantity = $goodsQuantity;
        $basketGoods->total_price = $request->json('data')['good_price'] * $goodsQuantity;
        $basketGoods->save();

        return response()->json([
            'success' => true,
            'response_data' => [
                'basket_id' => $request->get('basket')->id,
                'basket_total' => $basket->total,
                'message' => 'Successfully added goods to basket',
            ]
        ]);
    }
}