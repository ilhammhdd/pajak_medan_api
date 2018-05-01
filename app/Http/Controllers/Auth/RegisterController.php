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
        $this->validate(
            $request,
            [
                'auth_type' => 'required|exists:login_types,name',
                'full_name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|unique:users,username',
                'password' => 'required'
            ]
        );

        $authType = LoginType::where('name', $request->json('auth_type'))->first();

        $profile = new Profile();
        $profile->full_name = $request->json('full_name');
        $profile->phone_number = $request->json('phone_number');
        $profile->email = $request->json('email');
        $profileSaved = $profile->save();

        $user = new User();
        $user->role_id = 3;
        $user->email = $request->json('email');
        $user->username = $request->json('username');
        $user->password = Hash::make($request->json('password'));
        $user->loginType()->associate($authType);
        $user->save();

        $user->token = (string)$this->generateToken($user);
        $userSaved = $user->save();

        $customer = new Customer();
        $customer->user()->associate($user);
        $customer->profile()->associate($profile);
        $customerSaved = $customer->save();

        if (!($profileSaved && $userSaved && $customerSaved)) {
            return $this->jsonResponse(null, true, "gagal register user", 500);
        }

        return $this->jsonResponse(null, false, "berhasil register user");
    }
}
