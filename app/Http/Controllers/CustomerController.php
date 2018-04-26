<?php

namespace App\Http\Controllers;

use App\Address;
use App\Event;
use App\Payment;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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

        return $this->jsonResponse([
            'events' => $events
        ], true, 'berhasil mendapatkan semua events');
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

    public function postDeleteAddress(Request $request)
    {
        $deleteStatus = Address::destroy($request->json("data")["address_id"]);

        if ($deleteStatus) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    "deleted" => true,
                    "message" => "Address successfully deleted"
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'response_data' => [
                "deleted" => false,
                "message" => "Failed to delete address"
            ]
        ]);
    }

    public function postEditAddress(Request $request)
    {
        $editMain = false;
        $successEditMainAddress = false;
        $customerId = $request->json("data")["customer_id"];
        $addressId = $request->json("data")["address_id"];

        if ($request->json("data")["main"]) {
            $mainAddress = Address::where([
                ["customer_id", $customerId],
                ["main", true]
            ])->first();
            if ($mainAddress) {
                $editMain = true;
                $mainAddress->main = 0;
                $successEditMainAddress = $mainAddress->save();
            }
        }

        $address = Address::where([
            ["id", $addressId],
            ["customer_id", $customerId]
        ])->first();
        $address->name = $request->json("data")["name"];
        $address->main = $request->json("data")["main"] ? 1 : 0;
        $successEditAddress = $address->save();

        if ($editMain) {
            if ($successEditAddress && $successEditMainAddress) {
                return response()->json([
                    'success' => true,
                    'response_data' => [
                        'edit_success' => true,
                        'edited_address' => $address,
                        'message' => "Successfully edited address"
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'response_data' => [
                    'edit_success' => false,
                    'message' => "Failed to edit address"
                ]
            ]);
        }

        if ($successEditAddress) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'edit_success' => true,
                    'edited_address' => $address,
                    'message' => "Successfully edited address"
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'response_data' => [
                'edit_success' => false,
                'message' => "Failed to edit address"
            ]
        ]);
    }

    public function postAddAddress(Request $request)
    {
        $newAddress = new Address();
        $newAddress->customer_id = $request->json("data")["customer_id"];
        $newAddress->name = $request->json("data")["name"];
        $newAddress->main = $request->json("data")["main"];
        $addNewAddressSuccess = $newAddress->save();

        if ($request->json("data")["main"]) {
            $mainAddress = Address::where([
                ["customer_id", $request->json("data")["customer_id"]],
                ["main", true]
            ])->first();
            if ($mainAddress) {
                $mainAddress->main = 0;
                $mainAddress->save();
            }
        }

        if ($addNewAddressSuccess) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'add_success' => true,
                    'message' => 'Successfully added new address'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'response_data' => [
                'add_success' => false,
                'message' => 'Failed to add new address'
            ]
        ]);
    }

    public function postEditProfile(Request $request)
    {
        $mainProfile = Profile::find($request->json("data")["profile_id"]);
    }
}
