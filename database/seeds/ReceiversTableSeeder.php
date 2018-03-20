<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receivers')->insert([
            ['customer_id' => 1, 'profile_id' => 1],
            ['customer_id' => 1, 'profile_id' => 5],
            ['customer_id' => 1, 'profile_id' => 4],
            ['customer_id' => 2, 'profile_id' => 2]
        ]);
    }
}
