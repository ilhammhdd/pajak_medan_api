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
        $statusName = Status::find($request->get('basket')->status_id);

        return $this->jsonResponse([
            'basket' => [
                'id' => $request->get('basket')->id,
                'customer_id' => $request->get('basket')->customer_id,
                'total' => $request->get('basket')->total,
                'description' => $request->get('basket')->description,
                'status_name' => $statusName->name
            ]
        ], true, 'berhsil mendapatkan basker dari user tersebut');
    }
}