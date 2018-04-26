<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->headers->get('X-PajakMedan-Token')) {
                $token = (new Parser())->parse((string)$request->headers->get('X-PajakMedan-Token'));

                if (!$token->validate(new ValidationData())) {
                    return null;
                }

                if ($token->verify(new Sha256(), "TLOJQgY8Ppy7aJp5skaKDejqxAvK36VT")) {
                    $user = User::find($token->getClaim('id'));
                    if ($user->token == (string)$token) {
                        return $user;
                    }
                }
                return null;
            }
            return null;
        });
        return null;
    }
}
