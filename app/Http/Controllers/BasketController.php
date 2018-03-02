<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/1/2018
 * Time: 3:35 AM
 */

namespace App\Http\Controllers;


use App\Basket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function getBasket(Request $request)
    {
        $basket = DB::select(
            'SELECT * FROM baskets WHERE customer_id = ' . $request->json("data")["customer_id"] . ' AND status = FALSE'
        );

        if ($basket != null) {
            return response()->json([
                'success' => true,
                'message' => "Successfully get the basket of the user",
                'basket' => $basket
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'There is no unfinished basket with this user id'
        ]);
    }
}