<?php

namespace App\Http\Controllers\Auth;

use App\APITokenGenerator;
use App\Customer;
use App\Http\Controllers\Controller;
use App\LoginType;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = User::where('email', $request->json("data")["email"])->first();
        if ($user) {
            return response()->json([
                'success' => true,
                'registered' => false,
                'message' => "User with this email is already exists"
            ]);
        }

        $authType = LoginType::where('name', $request->json("data")["auth_type"])->first();

        $profile = new Profile();
        $profile->full_name = $request->json('data')["fullName"];
        $profile->phone_number = $request->json('data')["phoneNumber"];
        $profile->email = $request->json('data')["email"];
        $profileSaved = $profile->save();

        $user = new User();
        $user->role_id = 3;
        $user->email = $request->json('data')["email"];
        $user->username = $request->json('data')["username"];
        $user->password = Hash::make($request->json('data')["password"]);
        $user->api_token = APITokenGenerator::generate();
        $user->loginType()->associate($authType);
        $userSaved = $user->save();

        $customer = new Customer();
        $customer->user()->associate($user);
        $customer->profile()->associate($profile);
        $customerSaved = $customer->save();

        if (!($profileSaved && $userSaved && $customerSaved)) {
            return response()->json([
                'success' => true,
                'registered' => false,
                'message' => "Registration failed"
            ]);
        }

        return response()->json([
            'success' => true,
            'registered' => true,
            'message' => "Registration successful"
        ]);
    }
}
