<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $controller = new \App\Http\Controllers\Controller();

        $user1 = new User();
        $user1->role_id = 3;
        $user1->login_type_id = 1;
        $user1->email = "martin@gmail.com";
        $user1->username = "martin";
        $user1->password = Hash::make("password");
        $user1->save();

        $user1->token = $controller->generateToken($user1);
        $user1->save();

        $user2 = new User();
        $user2->role_id = 3;
        $user2->login_type_id = 1;
        $user2->email = "robert@gmail.com";
        $user2->username = "robert";
        $user2->password = Hash::make("password");
        $user2->save();

        $user2->token = $controller->generateToken($user2);
        $user2->save();
    }
}
