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

        if (count($payments) != 0) {
            $this->jsonResponse([
                'payments' => $payments
            ], true, 'Successfully get all payment');
        }
        return $this->jsonResponse(null, false, 'There are no payment method', 404);
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
                'customer_id' => $request->get('customer')->id
            ]
        );

        if ($profile) {
            return $this->jsonResponse([
                'profile' => $profile[0]
            ], true, "Successfully get the main profile");
        }

        return $this->jsonResponse(null, false, "There is no profile for this customer", 404);
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
            ['customer_id' => $request->get('customer')->id]
        );

        if (count($mainAddress) != 0) {
            return $this->jsonResponse([
                'main_address' => $mainAddress[0]
            ], true, 'Successfully get the main address');
        }

        return $this->jsonResponse(null, false, 'There are no main address for this customer', 404);
    }

    public function getAllAddresses(Request $request)
    {
        $address = Address::where('customer_id', $request->get('customer')->id)->get();

        if (count($address) != 0) {
            return $this->jsonResponse([
                'all_addresses' => $address
            ], true, 'Successfully get all addresses for this customer');
        }

        return $this->jsonResponse(null, false, 'There is no address for this customer', 404);
    }

    public function postDeleteAddress(Request $request)
    {
        $this->validate(
            $request,
            [
                'address_id' => 'required|exists:addresses,id'
            ]
        );

        $deleteStatus = Address::destroy($request->json('address_id'));

        if ($deleteStatus) {
            return $this->jsonResponse(null, true, "Address successfully deleted");
        }

        return $this->jsonResponse(null, false, "Failed to delete address", 500);
    }

    public function postEditAddress(Request $request)
    {
        $this->validate(
            $request,
            [
                'address_id' => 'required|exists:addresses,id',
                'name' => 'required',
                'main' => 'required'
            ]
        );

        $editMain = false;
        $successEditMainAddress = false;
        $addressId = $request->json('address_id');

        if ($request->json('main')) {
            $mainAddress = Address::where([
                ["customer_id", $request->get('customer')->id],
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
            ["customer_id", $request->get('customer')->id]
        ])->first();
        $address->name = $request->json('name');
        $address->main = $request->json('main') ? 1 : 0;
        $successEditAddress = $address->save();

        if ($editMain) {
            if ($successEditAddress && $successEditMainAddress) {
                return $this->jsonResponse([
                    'edited_address' => $address
                ], true, "Successfully edited address");
            }

            return $this->jsonResponse(null, false, "Failed to edit address", 500);
        }

        if ($successEditAddress) {
            return $this->jsonResponse([
                'edited_address' => $address
            ], true, "Successfully edited address");
        }

        return $this->jsonResponse(null, false, "Failed to edit address", 500);
    }

    public function postAddAddress(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'main' => 'required'
            ]
        );

        $newAddress = new Address();
        $newAddress->customer_id = $request->get('customer')->id;
        $newAddress->name = $request->json('name');
        $newAddress->main = $request->json('main');
        $addNewAddressSuccess = $newAddress->save();

        if ($request->json('main')) {
            $mainAddress = Address::where([
                ["customer_id", $request->get('customer')->id],
                ["main", true]
            ])->first();
            if ($mainAddress) {
                $mainAddress->main = 0;
                $mainAddress->save();
            }
        }

        if ($addNewAddressSuccess) {
            return $this->jsonResponse(null, true, 'Successfully added new address');
        }

        return $this->jsonResponse(null, false, 'Failed to add new address');
    }

    public function postEditProfile(Request $request)
    {
        $this->validate(
            $request,
            [
                'full_name' => 'required',
                'phone_number' => 'required'
            ]
        );

        $profile = Profile::find($request->get('customer')->profile_id);
        $profile->full_name = $request->json('full_name');
        $profile->phone_number = $request->json('phone_number');
        $saveProfile = $profile->save();

        if ($saveProfile) {
            return $this->jsonResponse(null, true, 'Successfully edit the profile');
        }

        return $this->jsonResponse(null, false, 'Failed to edit the profile');
    }
}
