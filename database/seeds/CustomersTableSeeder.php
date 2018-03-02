<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            ['user_id' => 1, 'profile_id' => 1],
            ['user_id' => 2, 'profile_id' => 2],
        ]);
    }
}
