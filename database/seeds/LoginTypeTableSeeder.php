<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoginTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('login_types')->insert([
            ['id' => 1, 'name' => "native"],
            ['id' => 2, 'name' => "google"],
            ['id' => 3, 'name' => "facebook"]
        ]);
    }
}
