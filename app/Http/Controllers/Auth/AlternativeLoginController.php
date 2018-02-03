<?php

namespace App\Http\Controllers\Auth;

use App\APITokenGenerator;
use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AlternativeLoginController extends Controller
{
    public function checkUser(Request $request)
    {
//        if ($request->json("data")["alternative_auth"]) {
//            $authUser = User::where('email', $request->json("data")["email"])->first();
//            if (!$authUser) {
//                $this->userDontExists($request);
//            } else {
//                $this->userExists($authUser);
//            }
//        }

        if ($request->json("data")["alternative_auth"]) {
            $authUser = User::where('email', $request->json("data")["email"])->first();
            if (!$authUser) {
                $newAPIToken = APITokenGenerator::generate();

                $newUser = new User();
                $newUser->role_id = 3;
                $newUser->email = $request->json("data")["email"];
                $newUser->username = $request->json("data")["id"];
                $newUser->password = Hash::make("password");
                $newUser->api_token = $newAPIToken;

                if ($request->json("data")["photo_url"]) {
                    $profilePhoto = new File();
                    $profilePhoto->file_path = $request->json("data")["photo_url"];
                    $profilePhoto->file_name = "profile photo";
                    $profilePhoto->save();
                    $newUser->file()->associate($profilePhoto);
                }
                
                $newUser->save();
                return response()->json([
                    'new_api_token' => $newAPIToken
                ]);
            }
            return response()->json([
                'message' => 'User with this email exists'
            ]);
        }
        return response()->json([
            'message' => 'An error has occured'
        ]);
    }

    public function userDontExists(Request $request)
    {
        $newAPIToken = APITokenGenerator::generate();

        $newUser = new User();
        $newUser->role_id = 3;
        $newUser->file_id = $request->json("data")["photo_url"];
        $newUser->email = $request->json("data")["email"];
        $newUser->username = $request->json("data")["id"];
        $newUser->password = Hash::make("password");
        $newUser->api_token = $newAPIToken;
        $newUser->save();

        return response()->json([
            'authenticated' => true,
            'api_token' => $newAPIToken,
            'message' => 'Alternative login success. User created'
        ]);
    }

    public
    function userExists(User $authUser)
    {
        return response()->json([
            'authenticated' => true,
            'api_token' => $authUser->api_token,
            'message' => 'Alternative login success. User existed'
        ]);
    }
}
