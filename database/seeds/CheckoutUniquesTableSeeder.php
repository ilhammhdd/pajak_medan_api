<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckoutUniquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 1000; $i++) {
            DB::table('checkout_uniques')->insert([
                ['number' => $i, 'used' => false]
            ]);
        }
    }
}
