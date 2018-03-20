<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/1/2018
 * Time: 3:35 AM
 */

namespace App\Http\Controllers;


use App\Basket;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function getBasket(Request $request)
    {
        $basket = $request->get('basket');
        $statusName = Status::find($basket->status_id);

        return response()->json([
            'success' => true,
            'response_data' => [
                'message' => "Successfully get the basket of the user",
                'basket' => [
                    'id' => $basket->id,
                    'customer_id' => $basket->customer_id,
                    'total' => $basket->total,
                    'description' => $basket->description,
                    'status_name' => $statusName->name
                ]
            ]
        ]);
    }
}