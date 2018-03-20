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
        $username = $request->json("data")["username"];
        $password = $request->json("data")["password"];

        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'authenticated' => false,
                    'message' => 'User with this username doesn\'t exists'
                ]
            ]);
        }
        if (Hash::check($password, $user->password)) {
            return response()->json([
                'success' => true,
                'response_data' => [
                    'authenticated' => true,
                    'user' => $user,
                    'profile' => $user->customer()->first()->profile()->first(),
                    'photo' => $user->file()->pluck('file_path')->first(),
                    'customer' => $user->customer()->first(),
                    'message' => 'User Authenticated'
                ]
            ]);
        }
        return response()->json([
            'success' => true,
            'response_data' => [
                'authenticated' => false,
                'message' => 'Password incorrect'
            ],
        ]);
    }
}