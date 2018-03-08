<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use App\Payment;
use Laravel\Lumen\Routing\Controller as BaseController;

class CustomerController extends BaseController
{
    public function getEvents()
    {
        $eventsAll = Event::all();
        $events = [];

        foreach ($eventsAll as $event) {
            $events[] = [
                "id" => $event->id,
                "file_path" => $event->file()->pluck('file_path')->first(),
                "name" => $event->name
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get all events',
            'events' => $events
        ]);
    }

    public function getPaymentMethod()
    {
        $paymentAll = Payment::all();
        $payments = [];

        foreach ($paymentAll as $payment) {
            $payments[] = [
                "payment_id" => $payment->id,
                "payment_image_url" => $payment->file()->pluck('file_path')->first(),
                "payment_name" => $payment->name,
                "payment_detail" => $payment->detail
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get all payment',
            'payments' => $payments
        ]);
    }
}
