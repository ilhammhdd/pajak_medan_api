<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/5/2018
 * Time: 8:19 AM
 */

namespace App\Http\Middleware;

use App\Basket;
use Closure;
use Illuminate\Support\Facades\DB;

class CheckBasketStatus
{
    public function handle($request, Closure $next, $status)
    {
        $basket = DB::select(
            'SELECT 
            baskets.id,
            baskets.customer_id,
            baskets.total,
            baskets.description,
            baskets.status_id
            FROM baskets 
            LEFT JOIN status ON baskets.status_id = status.id 
            WHERE baskets.customer_id = ' . $request->get('customer')->id . '
            AND status.name = :status',
            ['status' => $status]
        );

        if ($basket) {
            $request->attributes->set('basket', $basket[0]);
            return $next($request);
        }

        $newBasket = new Basket();
        $newBasket->customer_id = $request->get('customer')->id;
        $newBasket->total = 0;
        $newBasket->description = 'no description';
        $newBasket->status_id = 6;
        $newBasket->save();

        $request->attributes->set('basket', $newBasket);
        return $next($request);
    }
}