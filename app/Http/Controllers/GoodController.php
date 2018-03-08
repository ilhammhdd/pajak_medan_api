<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/27/2018
 * Time: 4:19 PM
 */

namespace App\Http\Controllers;


use App\Good;
use App\Review;
use App\User;
use Illuminate\Http\Request;

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
            'message' => 'Successfully get all goods of the given category',
            'goods' => $goodsJsonArray
        ]);
    }

    public function getReview(Request $request)
    {

    }
}