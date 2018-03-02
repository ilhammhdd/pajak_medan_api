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
            ['id' => 1, 'role_id' => 3, 'login_type_id' => 1, 'file_id' => null, 'email' => 'admin@admin.com', 'username' => 'admin', 'password' => Hash::make('pajakmedanjaya'), 'api_token' => \App\APITokenGenerator::generate()],
            ['id' => 2, 'role_id' => 3, 'login_type_id' => 1, 'file_id' => null, 'email' => 'robert@gmail.com', 'username' => 'robert', 'password' => Hash::make('asd'), 'api_token' => \App\APITokenGenerator::generate()]
        ]);
    }
}
