<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 3/5/2018
 * Time: 8:19 AM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckBasketStatus
{
    public function handle($request, Closure $next, $status)
    {
        $basket = DB::select(
            'SELECT baskets.id, baskets.customer_id, baskets.total, baskets.description, status.name AS status_name FROM baskets LEFT JOIN status ON baskets.status_id = status.id WHERE baskets.customer_id = ' . $request->json("data")["customer_id"] . ' AND status.name = :status',
            ['status' => $status]
        );

        if ($basket) {
            $request->attributes->set('basket', $basket);

            return $next($request);
        }

        return response()->json([
            'success' => true,
            'message' => 'There is no unfinished basket with this user id'
        ]);
    }
}