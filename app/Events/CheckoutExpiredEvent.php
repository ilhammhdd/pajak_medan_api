<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 4/7/2018
 * Time: 12:28 PM
 */

namespace App\Events;


use Illuminate\Support\Facades\DB;

class CheckoutExpiredEvent extends Event
{
    public $checkouts;

    public function __construct($customer_id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = date('Y-m-d H:i:s');

        $checkouts = DB::select(
            'SELECT c.id
            FROM checkouts c
            JOIN baskets b ON c.basket_id = b.id
            JOIN customers cu ON b.customer_id = cu.id
            WHERE cu.id = :customer_id
            AND c.expired <= str_to_date(:my_current_date, "%Y-%m-%d %H:%i:%s")',
            [
                'customer_id' => $customer_id,
                'my_current_date' => $currentDate
            ]
        );
        $this->checkouts = $checkouts;
    }
}