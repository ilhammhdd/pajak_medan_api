<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $this->validate(
            $request,
            [
                'username' => 'required|exists:users,username',
                'password' => 'required'
            ]
        );

        $user = User::where('username', $request->json('username'))->first();

        if (Hash::check($request->json('password'), $user->password)) {

            return $this->jsonResponse([
                'user' => $user,
                'profile' => $user->customer()->first()->profile()->first(),
                'photo' => $user->file()->pluck('file_path')->first(),
                'customer' => $user->customer()->first(),
                'message' => 'User Authenticated'
            ], true, 'Successfully logged in');
        }

        return $this->jsonResponse(null, false, 'Failed to login, wrong password', 401);
    }
}