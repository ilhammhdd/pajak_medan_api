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
        $this->validate(
            $request,
            [
                'category_id' => 'required|exists:categories,id'
            ]
        );

        $goods = Good::where('category_id', $request->json('category_id'))->get();
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

        return $this->jsonResponse([
            'goods' => $goodsJsonArray
        ], true, 'berhasil mendapatkan goods berdasrakan category');
    }

    public function getReview(Request $request)
    {

    }

    public function buyGoods(Request $request)
    {
        $this->validate(
            $request,
            [
                'good_id' => 'required|exists:goods,id',
                'good_quantity' => 'required',
                'good_price' => 'required'
            ]
        );

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
                'good_id' => $request->json('good_id'),
                'basket_id' => $request->get('basket')->id
            ]
        );

        $basket = Basket::find($request->get('basket')->id);

        if ($goodInBasket == []) {
            $newBasketGoods = new BasketGoods();
            $newBasketGoods->good_id = $request->json('good_id');
            $newBasketGoods->basket_id = $request->get('basket')->id;
            $newBasketGoods->good_quantity = $request->json('good_quantity');
            $newBasketGoods->total_price = $request->json('good_price') * $request->json('good_quantity');
            $newBasketGoods->save();

            $basket->customer_id = $request->get('customer')->id;
            $basket->total = $basket->total + ($request->json('good_quantity') * $request->json('good_price'));
            $basket->total_items = ++$basket->total_items;
            $basket->description = "still no description";
            $basket->status_id = 6;
            $basket->save();

            return $this->jsonResponse([
                'basket_id' => $request->get('basket')->id,
                'basket_total' => $basket->total,
            ], true, 'berhasil membuat basket_goods baru');
        }

        $basket->customer_id = $request->get('customer')->id;
        $basket->total = $basket->total + ($request->json('good_quantity') * $request->json('good_price'));
        $basket->description = "still no description";
        $basket->status_id = 6;
        $basket->save();

        $goodsQuantity = $goodInBasket[0]->good_quantity + $request->json('good_quantity');

        $basketGoods = BasketGoods::find($goodInBasket[0]->id);
        $basketGoods->good_quantity = $goodsQuantity;
        $basketGoods->total_price = $request->json('good_price') * $goodsQuantity;
        $basketGoods->save();

        return $this->jsonResponse([
            'basket_id' => $request->get('basket')->id,
            'basket_total' => $basket->total
        ], true, 'berhasil menambahakan good kedalam basket');
    }
}