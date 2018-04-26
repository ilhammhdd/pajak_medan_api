<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Validation\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Controller extends BaseController
{
    protected $signer;

    public function __construct()
    {
        $this->signer = new Sha256();
    }

    public function generateToken(User $user)
    {
        return $token = (new Builder())
            ->setIssuedAt(time())
            ->setExpiration(time() + 178600)
            ->set('id', $user->id)
            ->set('role_id', $user->role_id)
            ->set('login_type_id', $user->login_type_id)
            ->set('file_id', $user->file_id)
            ->set('email', $user->email)
            ->set('username', $user->username)
            ->sign($this->signer, "TLOJQgY8Ppy7aJp5skaKDejqxAvK36VT")
            ->getToken();
    }

    protected function formatValidationErrors(Validator $validator)
    {
        return [
            "response_data" => null,
            "success" => false,
            "message" => $validator->errors()->all()
        ];
    }

    protected function jsonResponse($data, $succes, $message, $statusCode = 200, $headers = [])
    {
        return response()->json([
            'response_data' => $data,
            'success' => $succes,
            'message' => $message
        ], $statusCode, $headers);
    }
}
