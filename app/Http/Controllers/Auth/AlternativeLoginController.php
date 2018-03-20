<?php

namespace App\Http\Controllers\Auth;

use App\APITokenGenerator;
use App\Customer;
use App\File;
use App\LoginType;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AlternativeLoginController extends Controller
{
    public function checkUser(Request $request)
    {
        $loginType = LoginType::where('name', $request->json("data")["auth_type"])->first();

        if (!$loginType) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'authenticated' => false,
                    'message' => "This type of login isn't allowed"
                ]
            ]);
        }

        if ($request->json("data")["alternative_auth"]) {
            $authUser = User::where('email', $request->json("data")["email"])->first();
            if (!$authUser) {
                $newAPIToken = APITokenGenerator::generate();

                $profile = new Profile();
                $profile->full_name = $request->json('data')["full_name"];
                $profile->email = $request->json('data')["email"];
                $profile->save();

                $newUser = new User();
                $newUser->role_id = 3;
                $newUser->email = $request->json("data")["email"];
                $newUser->username = $request->json("data")["id"];
                $newUser->password = Hash::make("password");
                $newUser->api_token = $newAPIToken;
                $newUser->loginType()->associate($loginType);

                if ($request->json("data")["photo_url"] != "null") {
                    $profilePhoto = new File();
                    $profilePhoto->file_path = $request->json("data")["photo_url"];
                    $profilePhoto->file_name = "profile photo";
                    $profilePhoto->save();
                    $newUser->file()->associate($profilePhoto);
                }

                $newUser->save();

                $customer = new Customer();
                $customer->user()->associate($newUser);
                $customer->profile()->associate($profile);
                $customer->save();

                return response()->json([
                    'success' => true,
                    'response_data' => [
                        'authenticated' => true,
                        'user' => $newUser,
                        'profile' => $newUser->customer()->first()->profile()->first(),
                        'customer' => $newUser->customer()->first(),
                        'photo' => $newUser->file()->pluck('file_path')->first(),
                        'message' => 'Alternative login success, and new user has been created'
                    ],
                ]);
            } elseif ($authUser->username == $request->json("data")["id"]) {
                return response()->json([
                    'success' => true,
                    'response_data' => [
                        'authenticated' => true,
                        'user' => $authUser,
                        'profile' => $authUser->customer()->first()->profile()->first(),
                        'customer' => $authUser->customer()->first(),
                        'photo' => $authUser->file()->pluck('file_path')->first(),
                        'message' => 'Alternative login success'
                    ],
                ]);
            }
            return response()->json([
                'success' => true,
                'response_data' => [
                    'authenticated' => false,
                    'email_taken' => true,
                    'message' => 'This email is already taken'
                ],
            ]);
        }
        return response()->json([
            'success' => true,
            'response_data' => [
                'authenticated' => false,
                'message' => 'An error has occured'
            ],
        ]);
    }
}