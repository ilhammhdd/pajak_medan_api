<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Event;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'response_data' => [
                'message' => 'Successfully get all events',
                'events' => $events
            ]
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
            'response_data' => [
                'message' => 'Successfully get all payment',
                'payments' => $payments
            ]
        ]);
    }

    public function getMainProfile(Request $request)
    {
        $profile = DB::select(
            'SELECT
            profiles.id AS profile_id,
            profiles.full_name AS profile_full_name,
            profiles.phone_number AS profile_phone_number,
            profiles.email AS profile_email
            FROM 
            profiles
            LEFT JOIN customers ON profiles.id=customers.profile_id
            WHERE customers.id = :customer_id',
            [
                'customer_id' => $request->json("data")["customer_id"]
            ]
        );

        if ($profile) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'profile' => $profile[0],
                    'message' => "Successfully get the main profile"
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'response_data' => [
                'profile' => $profile,
                'message' => "There is no profile for this customer"
            ]
        ]);
    }

    public function getMainAddress(Request $request)
    {
        $mainAddress = DB::select(
            '
            SELECT 
            addresses.id,
            addresses.customer_id,
            addresses.name,
            addresses.main
            FROM addresses
            WHERE customer_id = :customer_id
            AND main = TRUE
            ',
            ['customer_id' => $request->json("data")["customer_id"]]
        );

        if ($mainAddress) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'main_address' => $mainAddress[0],
                    'message' => 'Successfully get the main address'
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'response_data' => [
                'message' => 'There are no main address for this customer'
            ]
        ]);
    }

    public function getAllAddresses(Request $request)
    {
        $address = Address::where('customer_id', $request->json("data")["customer_id"])->get();

        return response()->json([
            'success' => true,
            'response_data' => [
                'all_addresses' => $address,
                'message' => 'Successfully get all addresses for this customer'
            ]
        ]);
    }
}
