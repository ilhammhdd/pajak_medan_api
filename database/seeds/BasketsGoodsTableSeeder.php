<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasketsGoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('baskets_goods')->insert([
            ['good_id' => 2, 'basket_id' => 1, 'good_quantity' => 2, 'total_price' => 40000],
            ['good_id' => 4, 'basket_id' => 1, 'good_quantity' => 4, 'total_price' => 32000],
            ['good_id' => 5, 'basket_id' => 1, 'good_quantity' => 1, 'total_price' => 7500],
            ['good_id' => 8, 'basket_id' => 1, 'good_quantity' => 3, 'total_price' => 22100],
            ['good_id' => 1, 'basket_id' => 3, 'good_quantity' => 1, 'total_price' => 150000],
            ['good_id' => 3, 'basket_id' => 3, 'good_quantity' => 3, 'total_price' => 30000],
            ['good_id' => 7, 'basket_id' => 3, 'good_quantity' => 4, 'total_price' => 44000],
            ['good_id' => 9, 'basket_id' => 3, 'good_quantity' => 5, 'total_price' => 48000],
        ]);
    }
}
