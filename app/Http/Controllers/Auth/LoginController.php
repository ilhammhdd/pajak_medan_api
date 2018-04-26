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
                'data.username' => 'required|exists:users,username',
                'data.password' => 'required'
            ]
        );

        $user = User::where('username', $request->json('data')['username'])->first();

        if (Hash::check($request->json('data')['password'], $user->password)) {

            return $this->jsonResponse([
                'authenticated' => true,
                'user' => $user,
                'profile' => $user->customer()->first()->profile()->first(),
                'photo' => $user->file()->pluck('file_path')->first(),
                'customer' => $user->customer()->first(),
                'message' => 'User Authenticated'
            ], true, 'user berhasil login');
        }

        return $this->jsonResponse([
            'authenticated' => false
        ], false, 'user gagal login', 401);
    }
}