<?php

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
        DB::table('users')->insert([
            ['role_id' => 1, 'login_type_id' => 1, 'file_id' => null, 'email' => 'admin@admin.com', 'username' => 'admin', 'password' => Hash::make('pajakmedanjaya'), 'api_token' => \App\APITokenGenerator::generate()],
            ['role_id' => 2, 'login_type_id' => 1, 'file_id' => null, 'email' => 'milham939@gmail.com', 'username' => 'ilhammhdd', 'password' => Hash::make('asd'), 'api_token' => \App\APITokenGenerator::generate()],
            ['role_id' => 3, 'login_type_id' => 1, 'file_id' => null, 'email' => 'robert@gmail.com', 'username' => 'robert', 'password' => Hash::make('asd'), 'api_token' => \App\APITokenGenerator::generate()]
        ]);
    }
}
