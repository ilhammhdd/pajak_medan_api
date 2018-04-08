<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 4/7/2018
 * Time: 12:48 PM
 */

namespace App\Listeners;


use App\Checkout;
use App\Events\CheckoutExpiredEvent;
use Illuminate\Support\Facades\DB;

class ChangeExpiredCheckoutsStatus
{
    public function handle(CheckoutExpiredEvent $event)
    {
        foreach ($event->checkouts as $checkout) {
            $expiredCheckout = Checkout::find($checkout->id);
            $expiredCheckout->status_id = 9;
            $expiredCheckout->save();
        }
    }
}