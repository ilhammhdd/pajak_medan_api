<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            ['id' => 1, 'name' => 'payment_not_issued'],
            ['id' => 2, 'name' => 'payment_issued'],
            ['id' => 3, 'name' => 'payment_approved'],
            ['id' => 4, 'name' => 'payment_failed'],
            ['id' => 5, 'name' => 'basket_finished'],
            ['id' => 6, 'name' => 'basket_unfinished'],
            ['id' => 7, 'name' => 'user_signedin'],
            ['id' => 8, 'name' => 'user_signedout'],
            ['id' => 9, 'name' => 'payment_expired']
        ]);
    }
}
